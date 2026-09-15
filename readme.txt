=== Hoomana Native Comment Guard ===
Contributors: hoomanemon
Tags: anti-spam, comment spam, honeypot, no captcha, lightweight
Requires at least: 5.9
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 0.1.6
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Block automated comment spam quietly — no CAPTCHA, no configuration, and no friction for real visitors.

== Description ==

Most comment-spam tools add friction for real visitors: CAPTCHAs to solve, services that track them, or settings pages to configure. Hoomana Native Comment Guard takes a quieter approach for the native WordPress comment form.

* Removes the website field to reduce link-spam incentives.
* Adds a rotating, signed honeypot field that real visitors never see.
* Rejects implausibly fast automated submissions.
* Does not send external requests, create cookies, or track visitors.
* Needs no account and no configuration.
* Shows a small Dashboard count of detected spam attempts.

Hoomana Native Comment Guard is a lightweight first line of defense, designed for native WordPress comment forms. Sites targeted by sophisticated or high-volume spam may still need moderation rules or a dedicated anti-spam service. REST and XML-RPC comment clients are intentionally left unchanged for compatibility. Developers can bypass validation for a custom integration with the `hcncg_skip_comment_validation` filter.

== Installation ==

1. Upload the `hoomana-native-comment-guard` folder to `/wp-content/plugins/`, or install it through the WordPress Plugins screen.
2. Activate **Hoomana Native Comment Guard**.
3. That is all. Protection starts on native comment forms immediately.

== Frequently Asked Questions ==

= Does it send data to another service? =

No. All checks run on your WordPress site. The plugin does not create cookies or send visitor data externally.

= Will it affect existing comments? =

No. It only checks new submissions through the native form.

= Does it support custom comment forms? =

Only forms that use the standard WordPress comment hooks are protected automatically. Custom integrations can add the same fields or use the `hcncg_skip_comment_validation` filter.

= Will it slow down my site? =

No meaningful performance impact is expected. The plugin adds a few small fields to the native comment form and performs local checks only when a comment is submitted. It makes no external requests.

= Does it work with my theme? =

It works with themes that use the standard WordPress comment form and its hooks. A fully custom comment form needs an integration check.

= What if a real visitor is blocked? =

The time check is only three seconds, which a normal commenter is very unlikely to trigger. If it happens, ask the visitor to reload the page and submit again. If your site has custom comment handling, test that integration or use the documented bypass filter.

= Does it work with page caching? =

Yes, including cached comment-form HTML. However, after you enable or change an aggressive full-page cache, purge its existing cache once so visitors receive the current form fields. Do not use a cache or optimization rule that removes hidden form inputs from comment forms.

= Is this a replacement for every anti-spam tool? =

It is intentionally a small first line of defense. Sites targeted by sophisticated or high-volume spam may also need moderation rules or a dedicated anti-spam service.

== Privacy ==

Hoomana Native Comment Guard does not collect, transmit, or store personal data. It stores only a site-local count of blocked submissions.

== Changelog ==

= 0.1.6 =
* Updates the public repository URL.

= 0.1.5 =
* Renames the plugin to Hoomana Native Comment Guard.
* Uses enqueued CSS for the honeypot field.
* Removes bundled translation files for WordPress.org distribution.

= 0.1.4 =
* Prepares the release for WordPress.org submission.

= 0.1.3 =
* Improves the public listing copy and updates the WordPress.org contributor username.

= 0.1.2 =
* Improves honeypot accessibility and avoids iterating over all submitted form fields.
* Removes the optional legacy translation loader.

= 0.1.1 =
* Improves internationalization support.

= 0.1.0 =
* First public beta.
