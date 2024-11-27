<footer class="footer" id="footer">
    <div id="copy" class="hidden-print">
        Copyright <span style="font-size:16px">&copy;</span> {{ date('Y') }}
        | <a href="{{ Option::get('app_owner_url', '#') }}" target="_blank"
            title="{{ Option::get('app_tagline', 'Laravel app description') }}">{{ Option::get('app_owner', 'PT. Chakra') }}</a>
        </a>
    </div>
</footer>
