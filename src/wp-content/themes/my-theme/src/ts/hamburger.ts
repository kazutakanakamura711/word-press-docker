export function initHamburger(): void {
  const btn = document.querySelector<HTMLButtonElement>(".l-header__hamburger");
  const closeBtn = document.querySelector<HTMLButtonElement>(".l-header__nav-close");
  const nav = document.querySelector<HTMLElement>(".l-header__nav");
  const overlay = document.querySelector<HTMLElement>(".l-header-overlay");

  if (!btn || !closeBtn || !nav || !overlay) return;

  // ハンバーガーボタンでドロワーを開く
  btn.addEventListener("click", () => {
    nav.classList.add("is-open");
    overlay.classList.add("is-active");
    document.body.style.overflow = "hidden";
  });

  // ドロワー内×ボタンで閉じる
  closeBtn.addEventListener("click", closeMenu);

  // オーバーレイクリックで閉じる
  overlay.addEventListener("click", closeMenu);

  // ESCキーで閉じる
  document.addEventListener("keydown", (e: KeyboardEvent) => {
    if (e.key === "Escape") closeMenu();
  });

  function closeMenu(): void {
    nav!.classList.remove("is-open");
    overlay!.classList.remove("is-active");
    document.body.style.overflow = "";
  }
}
