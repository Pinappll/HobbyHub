import { defineConfig } from "vite";
import path from "path";

export default defineConfig({
build: {
        lib: {
            entry: path.resolve(__dirname, "./src/js/main.js"),
            name: "ESGI_framework",
            //formats: ["es"],
        }
}, // ...
});
