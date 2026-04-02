/**
 * medical-theme メインスクリプト
 * - ハンバーガーメニューの開閉
 * - スクロール時のヘッダースタイル切替
 */

const hamburger = document.getElementById("js-hamburger");
const drawer = document.getElementById("js-drawer");
const overlay = document.getElementById("js-overlay");
const drawerPanel = document.getElementById("js-drawer-panel");
const drawerClose = document.getElementById("js-drawer-close");

function openDrawer(): void {
  if (!drawer || !overlay || !drawerPanel || !hamburger) return;
  drawer.classList.remove("pointer-events-none");
  overlay.classList.remove("opacity-0");
  drawerPanel.classList.remove("translate-x-full");
  hamburger.setAttribute("aria-expanded", "true");
  document.body.style.overflow = "hidden";
}

function closeDrawer(): void {
  if (!drawer || !overlay || !drawerPanel || !hamburger) return;
  overlay.classList.add("opacity-0");
  drawerPanel.classList.add("translate-x-full");
  hamburger.setAttribute("aria-expanded", "false");
  document.body.style.overflow = "";
  // transition完了後にpointer-events-noneを戻す
  setTimeout(() => {
    drawer.classList.add("pointer-events-none");
  }, 300);
}

hamburger?.addEventListener("click", openDrawer);
drawerClose?.addEventListener("click", closeDrawer);
overlay?.addEventListener("click", closeDrawer);

// Escキーで閉じる
document.addEventListener("keydown", (e: KeyboardEvent) => {
  if (e.key === "Escape") closeDrawer();
});
