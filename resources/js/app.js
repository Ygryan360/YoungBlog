import "./bootstrap";
import { createIcons, Menu, ArrowRight, Globe, Home } from "lucide";
// import { createIcons } from "lucide";

// Caution, this will import all the icons and bundle them.
// createIcons({ icons });

// Recommended way, to include only the icons you need.

createIcons({
    icons: {
        Menu,
        ArrowRight,
        Globe,
        Home,
    },
});
