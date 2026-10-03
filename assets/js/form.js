/**
 * Contact form. Posts to Formspree over fetch, then crossfades to a success
 * state and resets. On failure the form stays filled in and shows the error.
 */
const FORMSPREE_ENDPOINT = "https://formspree.io/f/xrpbndan";
const RESET_AFTER_MS = 3200;
const SWAP_MS = 350;
const FALLBACK_ERROR = "Something went wrong. Please try again, or email me directly.";

const wait = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

/** Sends the form to Formspree. Throws with a readable message on failure. */
async function send(formData) {
  let response;
  try {
    response = await fetch(FORMSPREE_ENDPOINT, {
      method: "POST",
      body: formData,
      headers: { Accept: "application/json" },
    });
  } catch {
    throw new Error("Could not reach the server. Check your connection and try again.");
  }
  if (response.ok) return;

  const data = await response.json().catch(() => null);
  const message = data?.errors?.map((err) => err.message).join(" ") || FALLBACK_ERROR;
  throw new Error(message);
}

/** Crossfades between the form and the success view. */
async function swap(from, to) {
  from.classList.add("is-leaving");
  await wait(SWAP_MS);
  from.classList.remove("is-leaving", "flex");
  from.classList.add("hidden");
  to.classList.add("is-entering");
  to.classList.remove("hidden");
  to.classList.add("flex");
  void to.offsetWidth;
  to.classList.remove("is-entering");
}

export function initContactForm(container) {
  const form = container.querySelector("[data-form]");
  const done = container.querySelector("[data-form-done]");
  const error = container.querySelector("[data-form-error]");
  const button = form.querySelector('button[type="submit"]');
  const label = form.querySelector("[data-submit-label]");
  let busy = false;

  const setBusy = (isBusy) => {
    busy = isBusy;
    button.disabled = isBusy;
    label.textContent = isBusy ? "Sending…" : "Send message";
  };

  const showError = (message) => {
    error.textContent = message;
    error.hidden = !message;
  };

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    if (busy) return;
    setBusy(true);
    showError("");

    try {
      await send(new FormData(form));
    } catch (err) {
      showError(err.message);
      setBusy(false);
      return;
    }

    await swap(form, done);
    await wait(RESET_AFTER_MS);
    form.reset();
    setBusy(false);
    await swap(done, form);
  });
}
