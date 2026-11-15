<?php

namespace Tests\Feature;

use App\Mail\ContactAutoReplyMail;
use App\Mail\OrderPlacedMail;
use App\Mail\OrderStatusMail;
use App\Mail\PaymentProofReceivedMail;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OrderNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_emails_the_buyer(): void
    {
        Mail::fake();

        $product = $this->makeProduct();
        $sessionId = $this->seedCart($product, 1);

        $this->post(route('checkout.process'), $this->checkoutPayload())->assertRedirect();

        $order = Order::firstOrFail();

        Mail::assertSent(OrderPlacedMail::class, function (OrderPlacedMail $mail) use ($order) {
            return $mail->hasTo('buyer@example.com')
                && $mail->order->id === $order->id
                && str_contains($mail->render(), $order->order_number);
        });

        $this->assertSame(0, Cart::where('session_id', $sessionId)->count());
    }

    public function test_contact_form_sends_an_auto_reply(): void
    {
        Mail::fake();

        $this->post(route('contact.submit'), [
            'name' => 'Test Sender',
            'email' => 'sender@example.com',
            'message' => 'I would like to know more about the hand sanitizer.',
        ])->assertRedirect();

        Mail::assertSent(ContactAutoReplyMail::class, function (ContactAutoReplyMail $mail) {
            return $mail->hasTo('sender@example.com')
                && $mail->contactMessage->email === 'sender@example.com'
                && str_contains($mail->render(), 'hand sanitizer');
        });
    }

    public function test_payment_proof_emails_a_confirmation(): void
    {
        Mail::fake();
        Storage::fake('public');

        $user = User::factory()->create();
        $order = $this->makeOrder($user);

        $proof = UploadedFile::fake()->createWithContent(
            'proof.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8DwHwAFAAH/q842iQAAAABJRU5ErkJggg==')
        );

        $this->actingAs($user)
            ->post(route('checkout.proof', $order->id), [
                'payment_method_used' => 'bkash',
                'transaction_id' => 'TX-98765',
                'proof_image' => $proof,
            ])
            ->assertRedirect(route('checkout.success', $order->id));

        Mail::assertSent(PaymentProofReceivedMail::class, function (PaymentProofReceivedMail $mail) use ($order) {
            return $mail->hasTo($order->guest_email)
                && $mail->order->id === $order->id
                && str_contains($mail->render(), 'TX-98765');
        });
    }

    public function test_admin_status_change_emails_the_customer(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['is_admin' => true]);
        $order = $this->makeOrder($admin);

        $this->actingAs($admin)
            ->patch(route('admin.orders.updateStatus', $order->id), ['status' => 'shipped'])
            ->assertRedirect(route('admin.orders.show', $order->id));

        Mail::assertSent(OrderStatusMail::class, function (OrderStatusMail $mail) {
            return $mail->hasTo('buyer@example.com')
                && $mail->status === 'shipped'
                && str_contains($mail->render(), 'shipped');
        });
    }

    private function makeOrder(User $user): Order
    {
        $product = $this->makeProduct();

        $order = Order::create([
            'order_number' => 'ORD-MAIL-' . $user->id,
            'guest_email' => 'buyer@example.com',
            'user_id' => $user->id,
            'status' => 'pending',
            'subtotal' => 100,
            'total' => 100,
            'stock_reserved_at' => now(),
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => 100,
            'quantity' => 1,
            'subtotal' => 100,
        ]);

        return $order;
    }

    private function seedCart(Product $product, int $quantity): string
    {
        $this->startSession();

        $sessionId = session()->getId();

        Cart::create([
            'session_id' => $sessionId,
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);

        $this->withCookie(config('session.cookie'), $sessionId);

        return $sessionId;
    }

    private function makeProduct(): Product
    {
        $category = Category::create([
            'name' => 'Personal Care',
            'slug' => 'personal-care',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        return Product::create([
            'name' => 'Hand Sanitizer',
            'slug' => 'hand-sanitizer',
            'description' => '<p>Test product</p>',
            'price' => 100,
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'is_active' => true,
        ]);
    }

    private function checkoutPayload(): array
    {
        return [
            'first_name' => 'Test',
            'last_name' => 'Buyer',
            'email' => 'buyer@example.com',
            'phone' => '01700000000',
            'address_line1' => '1 Test Road',
            'city' => 'Khulna',
            'postal_code' => '9100',
            'country' => 'Bangladesh',
        ];
    }
}
