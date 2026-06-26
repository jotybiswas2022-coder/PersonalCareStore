<?php

namespace Database\Seeders;

use App\Models\Policy;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    public function run(): void
    {
        Policy::create([
            'type'    => 'privacy_policy',
            'title'   => 'Privacy Policy',
            'is_active' => true,
            'content' => '<h2>Introduction</h2>
<p>Welcome to BasaFinder. We are committed to protecting your personal data and your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.</p>

<h2>Information We Collect</h2>
<p>We may collect personal information that you voluntarily provide to us when you:</p>
<ul>
<li>Register an account</li>
<li>Submit a contact form</li>
<li>Post a property listing</li>
<li>Subscribe to our newsletter</li>
</ul>

<h2>How We Use Your Information</h2>
<p>We use the collected information to:</p>
<ul>
<li>Provide, operate, and maintain our services</li>
<li>Improve, personalize, and expand our services</li>
<li>Communicate with you, including for customer support</li>
<li>Send you marketing and promotional communications (with your consent)</li>
<li>Detect, prevent, and address technical issues and fraud</li>
</ul>

<h2>Data Security</h2>
<p>We implement appropriate technical and organizational security measures to protect your personal data. However, no method of transmission over the Internet is 100% secure.</p>

<h2>Third-Party Services</h2>
<p>We do not sell, trade, or rent your personal data to third parties. We may share data with trusted service providers who assist us in operating our website, subject to confidentiality agreements.</p>

<h2>Your Rights</h2>
<p>You have the right to:</p>
<ul>
<li>Access, update, or delete your personal data</li>
<li>Withdraw consent at any time</li>
<li>Object to processing of your personal data</li>
<li>Request data portability</li>
</ul>

<h2>Changes to This Policy</h2>
<p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page.</p>

<h2>Contact Us</h2>
<p>If you have any questions about this Privacy Policy, please contact us through our website contact form.</p>',
        ]);

        Policy::create([
            'type'    => 'terms_of_service',
            'title'   => 'Terms of Service',
            'is_active' => true,
            'content' => '<h2>Acceptance of Terms</h2>
<p>By accessing or using BasaFinder, you agree to be bound by these Terms of Service. If you do not agree with any part of these terms, you may not use our services.</p>

<h2>Description of Service</h2>
<p>BasaFinder is a platform that connects property owners and tenants in Bangladesh. We provide a marketplace for listing and finding rental properties.</p>

<h2>User Responsibilities</h2>
<p>As a user, you agree to:</p>
<ul>
<li>Provide accurate and complete information when creating listings or accounts</li>
<li>Not post false, misleading, or fraudulent content</li>
<li>Respect the privacy and rights of other users</li>
<li>Comply with all applicable laws and regulations</li>
</ul>

<h2>Property Listings</h2>
<p>Property owners are solely responsible for the accuracy of their listings. BasaFinder does not verify or guarantee any property listing. We reserve the right to remove any listing that violates our policies.</p>

<h2>Limitation of Liability</h2>
<p>BasaFinder shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of the platform. We provide the service "as is" without any warranty.</p>

<h2>Account Termination</h2>
<p>We reserve the right to suspend or terminate accounts that violate these terms or engage in prohibited activities, without prior notice.</p>

<h2>Changes to Terms</h2>
<p>We may modify these terms at any time. Continued use of the platform after changes constitutes acceptance of the new terms.</p>

<h2>Governing Law</h2>
<p>These terms shall be governed by and construed in accordance with the laws of Bangladesh.</p>',
        ]);

        Policy::create([
            'type'    => 'cookie_policy',
            'title'   => 'Cookie Policy',
            'is_active' => true,
            'content' => '<h2>What Are Cookies</h2>
<p>Cookies are small text files that are stored on your device when you visit a website. They help us improve your browsing experience and provide personalized features.</p>

<h2>How We Use Cookies</h2>
<p>We use cookies for the following purposes:</p>
<ul>
<li><strong>Essential Cookies:</strong> Necessary for the basic functioning of our website, including session management and security.</li>
<li><strong>Functionality Cookies:</strong> Remember your preferences and settings to enhance your experience.</li>
<li><strong>Analytics Cookies:</strong> Help us understand how visitors interact with our website, allowing us to improve our services.</li>
</ul>

<h2>Third-Party Cookies</h2>
<p>We may use third-party services such as Google Analytics that set their own cookies. These services have their own privacy policies governing the use of your information.</p>

<h2>Managing Cookies</h2>
<p>You can control and manage cookies in your browser settings. Most browsers allow you to:</p>
<ul>
<li>View and delete cookies</li>
<li>Block cookies from specific sites</li>
<li>Block all cookies</li>
<li>Set preferences for cookie notifications</li>
</ul>
<p>Please note that disabling certain cookies may affect the functionality of our website.</p>

<h2>Updates to This Policy</h2>
<p>We may update this Cookie Policy from time to time. Any changes will be posted on this page.</p>

<h2>Contact Us</h2>
<p>If you have questions about our use of cookies, please contact us through our website.</p>',
        ]);
    }
}
