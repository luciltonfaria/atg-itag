var at = document.documentElement.getAttribute("data-layout");
if ((at = "vertical")) {
  // ==============================================================
  // Auto select left navbar
  // ==============================================================

  document.addEventListener("DOMContentLoaded", function () {
    "use strict";
    var isSidebar = document.getElementsByClassName("side-mini-panel");
    if (isSidebar.length > 0) {
      var url = window.location + "";
      var path = url.replace(
        window.location.protocol + "//" + window.location.host + "/",
        ""
      );

      //****************************
      // This is for
      //****************************

      function findMatchingElement() {
        var currentUrl = window.location.href;
        var anchors = document.querySelectorAll("#sidebarnav a");
        let finalUrl = "";

        let urlSplats = currentURL.split("?");
        let refinedUrl = urlSplats[0];

        let isQueryParameter = currentURL.includes("?");
        if(isQueryParameter){
          finalUrl = refinedUrl;
        }
        else{
          finalUrl = currentURL
        }
 
        for (var i = 0; i < anchors.length; i++) {
          if (anchors[i].href === finalUrl) {
            return anchors[i];
          }
        }

        return null; // Return null if no matching element is found
      }

      var elements = findMatchingElement();

      if (elements) {
        // Do something with the matching element
        elements.classList.add("active");
      }

      //****************************
      // Multilevel menu: manter apenas uma categoria ativa/aberta
      //****************************
      // Clique nos cabeçalhos de categoria (has-arrow)
      document
        .querySelectorAll("#sidebarnav > li > a.has-arrow")
        .forEach(function (header) {
          header.addEventListener("click", function (e) {
            e.preventDefault();
            const navRoot = this.closest("nav");
            const sideMenuRoot = document.querySelector(".sidebarmenu");

            // Limpeza global: garante exclusividade da seleção em toda a sidebar
            const cleanupRoot = sideMenuRoot || navRoot;
            if (cleanupRoot) {
              cleanupRoot
                .querySelectorAll("#sidebarnav > li > ul.first-level.in")
                .forEach(function (submenu) {
                  submenu.classList.remove("in");
                });
              cleanupRoot
                .querySelectorAll("#sidebarnav > li > a.has-arrow.active")
                .forEach(function (a) {
                  a.classList.remove("active");
                });
              cleanupRoot
                .querySelectorAll("#sidebarnav .first-level a.sidebar-link.active")
                .forEach(function (a) {
                  a.classList.remove("active");
                });
              cleanupRoot
                .querySelectorAll("#sidebarnav .sidebar-item.selected")
                .forEach(function (sel) {
                  sel.classList.remove("selected");
                });
            }

            // Abrir apenas o submenu da categoria clicada e marcar ativo
            const submenu = this.nextElementSibling;
            if (submenu && submenu.classList.contains("first-level")) {
              submenu.classList.add("in");
            }
            this.classList.add("active");
          });
        });

      // Clique em links internos (itens das categorias)
      document
        .querySelectorAll("#sidebarnav .first-level a.sidebar-link")
        .forEach(function (link) {
          link.addEventListener("click", function () {
            const navRoot = this.closest("nav");
            const sideMenuRoot = document.querySelector(".sidebarmenu");
            const firstLevel = this.closest("ul.first-level");
            const header = firstLevel && firstLevel.previousElementSibling;

            // Limpeza global: garante exclusividade em toda a sidebar
            const cleanupRoot = sideMenuRoot || navRoot;
            if (cleanupRoot) {
              cleanupRoot
                .querySelectorAll("#sidebarnav .first-level a.sidebar-link.active")
                .forEach(function (a) {
                  a.classList.remove("active");
                });
              cleanupRoot
                .querySelectorAll("#sidebarnav > li > a.has-arrow.active")
                .forEach(function (a) {
                  a.classList.remove("active");
                });
              cleanupRoot
                .querySelectorAll("#sidebarnav > li > ul.first-level.in")
                .forEach(function (submenu) {
                  submenu.classList.remove("in");
                });
              cleanupRoot
                .querySelectorAll("#sidebarnav .sidebar-item.selected")
                .forEach(function (sel) {
                  sel.classList.remove("selected");
                });
            }

            // Marcar apenas o item clicado e seu cabeçalho
            this.classList.add("active");
            if (header && header.classList.contains("has-arrow")) {
              header.classList.add("active");
            }
            if (firstLevel) {
              firstLevel.classList.add("in");
            }
          });
        });

      document
        .querySelectorAll("#sidebarnav > li > a.has-arrow")
        .forEach(function (link) {
          link.addEventListener("click", function (e) {
            e.preventDefault();
          });
        });

      //****************************
      // This is for show menu
      //****************************

      var closestNav = elements?.closest("nav[class^=sidebar-nav]");
      var menuid = (closestNav && closestNav.id) || "menu-right-mini-1";
      var menu = menuid[menuid.length - 1];

      var initialNav = document.getElementById("menu-right-mini-" + menu);
      if (initialNav) {
        initialNav.classList.add("d-block");
        // expand only the relevant first-level menu on initial load
        const groupToOpen = (function () {
          if (elements) {
            const parentUl = elements.closest("ul");
            if (parentUl) {
              const headerLink = parentUl.previousElementSibling;
              if (headerLink && headerLink.classList.contains("has-arrow")) {
                return headerLink;
              }
            }
          }
          // fallback: open only the first group
          return initialNav.querySelector("a.has-arrow");
        })();

        if (groupToOpen) {
          groupToOpen.classList.add("active");
          const submenu = groupToOpen.nextElementSibling;
          if (submenu) {
            submenu.classList.add("in");
          }
        }
      }
      var initialMini = document.getElementById("mini-" + menu);
      if (initialMini) {
        initialMini.classList.add("selected");
      }

      //****************************
      // This is for mini sidebar
      //****************************
      document
        .querySelectorAll("ul#sidebarnav ul li a.active")
        .forEach(function (link) {
          link.closest("ul").classList.add("in");
          link.closest("ul").parentElement.classList.add("selected");
        });
      document
        .querySelectorAll(".mini-nav .mini-nav-item")
        .forEach(function (item) {
          item.addEventListener("click", function () {
            var id = this.id;
            document
              .querySelectorAll(".mini-nav .mini-nav-item")
              .forEach(function (navItem) {
                navItem.classList.remove("selected");
              });
            this.classList.add("selected");
            // clear active/selected states and open submenus across all navs
            document
              .querySelectorAll(".sidebarmenu nav")
              .forEach(function (nav) {
                nav.querySelectorAll("a.active").forEach(function (a) {
                  a.classList.remove("active");
                });
                nav.querySelectorAll("ul.in").forEach(function (submenu) {
                  submenu.classList.remove("in");
                });
                nav.querySelectorAll(".selected").forEach(function (sel) {
                  sel.classList.remove("selected");
                });
              });
            document
              .querySelectorAll(".sidebarmenu nav")
              .forEach(function (nav) {
                nav.classList.remove("d-block");
              });
            var shownNav = document.getElementById("menu-right-" + id);
            if (shownNav) {
              shownNav.classList.add("d-block");
              // expand only the first-level dashboard group on icon click
              const groupHeader = shownNav.querySelector("a.has-arrow");
              if (groupHeader) {
                groupHeader.classList.add("active");
                const submenu = groupHeader.nextElementSibling;
                if (submenu) {
                  submenu.classList.add("in");
                }
              }
            }
            document.body.setAttribute("data-sidebartype", "full");
          });
        });
    }
  });
}

if ((at = "horizontal")) {
  function findMatchingElement() {
    var currentUrl = window.location.href;
    var anchors = document.querySelectorAll("#sidebarnavh ul#sidebarnav a");
    for (var i = 0; i < anchors.length; i++) {
      if (anchors[i].href === currentUrl) {
        return anchors[i];
      }
    }

    return null; // Return null if no matching element is found
  }
  var elements = findMatchingElement();

  if (elements) {
    elements.classList.add("active");
  }
  document
    .querySelectorAll("#sidebarnavh ul#sidebarnav a.active")
    .forEach(function (link) {
      link.closest("a").parentElement.classList.add("selected");
      link.closest("ul").parentElement.classList.add("selected");
    });
}

// ----------------------------------------
// Active 2 file at same time 
// ----------------------------------------

var currentURL =
  window.location != window.parent.location
    ? document.referrer
    : document.location.href;

var link = document.getElementById("get-url");
// Guard: only update link when element exists
if (link) {
  if (currentURL.includes("/main/index.html")) {
    link.setAttribute("href", "../main/index.html");
  } else if (currentURL.includes("/index.html")) {
    link.setAttribute("href", "./index.html");
  } else {
    link.setAttribute("href", "./");
  }
}
