<footer class="site-footer">
    <div class="container footer-inner">
        <p>&copy; {{ date('Y') }} {{ $profile->name }}. All rights reserved.</p>

        @php
            $footerSocialLinks = [
                ['label' => 'Facebook', 'url' => $profile->facebook_url ?: 'https://www.facebook.com/', 'icon' => 'fa-facebook-f'],
                ['label' => 'Instagram', 'url' => $profile->instagram_url ?: 'https://www.instagram.com/', 'icon' => 'fa-instagram'],
                ['label' => 'GitHub', 'url' => $profile->github_url ?: 'https://github.com/', 'icon' => 'fa-github'],
                ['label' => 'LinkedIn', 'url' => $profile->linkedin_url ?: 'https://www.linkedin.com/', 'icon' => 'fa-linkedin-in'],
                ['label' => 'Medium', 'url' => $profile->medium_url ?: 'https://medium.com/', 'icon' => 'fa-medium'],
            ];
        @endphp

        <nav class="footer-socials" id="footer-socials" aria-label="Social profiles">
            @foreach ($footerSocialLinks as $socialLink)
                <a
                    class="footer-social-link"
                    href="{{ $socialLink['url'] }}"
                    aria-label="{{ $socialLink['label'] }}"
                    title="{{ $socialLink['label'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <i class="fa-brands {{ $socialLink['icon'] }}" aria-hidden="true"></i>
                </a>
            @endforeach
        </nav>
    </div>
</footer>

<button class="back-to-top" type="button" aria-label="Back to top" data-back-to-top>
    <span class="back-to-top-icon" aria-hidden="true"></span>
</button>
