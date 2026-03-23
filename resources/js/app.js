import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.store("sidebar", {
    collapsed: false,
});

Alpine.start();
