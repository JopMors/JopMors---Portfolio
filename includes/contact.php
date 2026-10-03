<?php
/**
 * Contact + footer, back over the workspace photo.
 * The form posts to Formspree via assets/js/form.js; the action attribute is the
 * no-JS fallback.
 */
$field = 'w-full bg-transparent px-0 py-3 text-[1rem] outline-none transition-colors border-0 border-b placeholder:opacity-50 border-white/15 placeholder:text-white focus:border-white/60';
?>
      <section id="contact" class="relative min-h-[100svh] overflow-hidden px-6 pt-32 text-white md:px-12" data-contact>
        <div class="absolute inset-0" style="transform: scale(1.25)" data-contact-photo>
          <img src="assets/img/workspace/master.webp" alt="" loading="lazy" class="absolute inset-0 h-full w-full object-cover object-[41%_50%]">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-m-bg via-black/40 to-black/85"></div>

        <div class="relative mx-auto grid max-w-6xl gap-12 pt-[18svh] lg:grid-cols-[1fr_1.05fr] lg:items-end">
          <div>
            <p class="mb-6 flex items-center gap-3 text-[13px] font-medium uppercase tracking-[0.2em] text-white/70">
              <span class="h-px w-8 bg-white/50"></span>
              Contact
            </p>
            <h2 class="text-balance text-5xl font-semibold leading-[0.95] tracking-[-0.045em] md:text-8xl" data-reveal>Let&apos;s build something.</h2>
            <div class="mt-10 flex flex-wrap gap-2">
<?php foreach ($contactChannels as $c): ?>
              <a href="<?= e($c['href']) ?>"<?= $c['id'] === 'email' ? '' : ' target="_blank"' ?> rel="noopener noreferrer" class="lg lg-press channel-btn inline-flex rounded-full px-5 py-2.5 text-sm font-medium">
                <span class="channel-btn__fill" aria-hidden="true"></span>
                <span class="channel-btn__label inline-flex items-center gap-2">
                  <?= e($c['id'] === 'email' ? $c['value'] : $c['label']) ?>
                  <?= icon('arrow-up-right', 'h-4 w-4') ?>
                </span>
              </a>
<?php endforeach; ?>
            </div>
          </div>

          <div class="lg lg-strong overflow-hidden rounded-[28px] p-6 sm:p-9" data-contact-form>
            <form action="https://formspree.io/f/xrpbndan" method="POST" class="form-view flex flex-col gap-3" data-form>
              <input type="hidden" name="_subject" value="New message from your portfolio">
              <input type="text" name="_gotcha" tabindex="-1" autocomplete="off" aria-hidden="true" class="hidden">
              <div class="grid gap-3 sm:grid-cols-2 sm:gap-8">
                <input required name="name" aria-label="Your name" placeholder="Name" class="<?= $field ?>">
                <input required type="email" name="email" aria-label="Your email" placeholder="Email" class="<?= $field ?>">
              </div>
              <textarea required rows="4" name="message" aria-label="Your message" placeholder="What are you working on?" class="<?= $field ?> resize-none"></textarea>
              <p class="mt-2 text-sm" style="color: #ff6961" role="alert" hidden data-form-error></p>
              <button type="submit" class="mt-5 inline-flex items-center gap-2 self-start rounded-full px-6 py-3 text-sm font-medium transition-transform duration-300 active:scale-[0.97] disabled:opacity-60 bg-m-accent text-m-on-accent">
                <span data-submit-label>Send message</span>
                <?= icon('arrow-up-right') ?>
              </button>
            </form>
            <div class="form-view hidden min-h-[18rem] flex-col items-start justify-end gap-3" data-form-done>
              <span class="grid h-11 w-11 place-items-center rounded-full bg-m-accent text-m-on-accent"><?= icon('check', 'h-5 w-5') ?></span>
              <p class="text-2xl font-medium tracking-tight">Message sent.</p>
              <p class="opacity-60">Thanks — I&apos;ll get back to you soon.</p>
            </div>
          </div>
        </div>

        <footer class="relative mx-auto mt-32 flex max-w-6xl flex-wrap items-center justify-between gap-2 border-t border-white/10 pb-24 pt-6 text-sm text-white/50">
          <span>© <?= date('Y') ?> <?= e($site['name']) ?></span>
          <span>Designed and built by <?= e($site['name']) ?>.</span>
        </footer>
      </section>
