export function initHamburger(): void {
  const btn = document.querySelector<HTMLButtonElement>(".l-header__hamburger");
  const nav = document.querySelector<HTMLElement>(".l-header__nav");
  const overlay = document.querySelector<HTMLElement>(".l-header-overlay");

  if (!btn || !nav || !overlay) return;

  // 開閉トグル
  btn.addEventListener("click", () => {
    const isOpen = nav.classList.toggle("is-open");
    overlay.classList.toggle("is-active", isOpen);
    btn.setAttribute("aria-expanded", String(isOpen));
    // スクロール禁止
    document.body.style.overflow = isOpen ? "hidden" : "";
  });

  // オーバーレイクリックで閉じる
  overlay.addEventListener("click", closeMenu);

  // ESCキーで閉じる
  document.addEventListener("keydown", (e: KeyboardEvent) => {
    if (e.key === "Escape") closeMenu();
  });

  function closeMenu(): void {
    nav!.classList.remove("is-open");
    overlay!.classList.remove("is-active");
    btn!.setAttribute("aria-expanded", "false");
    document.body.style.overflow = "";
  }
}
