<table class="rv-table">
    <thead>
        <tr>
            <th style="width:3rem;">Image</th>
            <th style="width:18%;">Product</th>
            <th style="width:14%;">Reviewer</th>
            <th style="width:8%;">Rating</th>
            <th style="width:22%;">Review</th>
            <th style="width:3.5rem;">Photo</th>
            <th style="width:9%;">Reply</th>
            <th style="width:10%;">Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reviews as $review)
            <tr>
                <td>
                    @if($review->product && $review->product->images && count($review->product->images) > 0)
                        <img src="{{ config('app.storage_url') . ltrim(preg_replace('#^storage/#', '', $review->product->images[0]), '/') }}" alt="" class="rv-prod-img">
                    @else
                        <div class="rv-prod-placeholder">N/A</div>
                    @endif
                </td>
                <td>
                    @if($review->product)
                        <a href="{{ route('products.show', $review->product_id) }}" class="rv-prod-link" target="_blank">{{ $review->product->name }}</a>
                    @else
                        <span style="color: #9ca3af;">Deleted</span>
                    @endif
                </td>
                <td>
                    <div class="rv-reviewer">
                        <div class="rv-avatar">
                            {{ strtoupper(substr($review->user->name ?? $review->guest_name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="rv-name">{{ $review->user->name ?? $review->guest_name ?? 'Anonymous' }}</span>
                    </div>
                </td>
                <td>
                    <div class="rv-stars">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</div>
                </td>
                <td>
                    <span class="rv-body" title="{{ $review->body ? strip_tags($review->body) : '' }}">{{ $review->body ? Str::limit($review->body, 80) : '—' }}</span>
                </td>
                <td>
                    @if($review->image_url)
                        <a href="{{ $review->image_url }}" target="_blank" class="rv-thumb-wrap">
                            <img src="{{ $review->image_url }}" alt="Review photo">
                            <span class="thumb-overlay">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </span>
                        </a>
                    @else
                        <span class="rv-thumb-none">—</span>
                    @endif
                </td>
                <td>
                    <span class="rv-reply-badge {{ $review->admin_reply ? 'replied' : 'no-reply' }}">
                        <span class="badge-dot"></span>
                        {{ $review->admin_reply ? 'Replied' : 'No Reply' }}
                    </span>
                </td>
                <td>
                    <span class="rv-date">{{ $review->created_at->format('M d, Y') }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    <div class="rv-empty">
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </div>
                        <div class="empty-title">No reviews yet</div>
                        <div class="empty-sub">Reviews from customers will appear here.</div>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@if(method_exists($reviews, 'links'))
    <div class="rv-pagination">
        {{ $reviews->links() }}
    </div>
@endif
