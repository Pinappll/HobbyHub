import { defineConfig } from "vite";
import path from "path";

export default defineConfig({
	build: {
		lib: {
			entry: path.resolve(__dirname, "./src/js/main.js"),
			name: "ESGI_framework",
			formats: ["es"],
		},
		rollupOptions: {
			output: {
				entryFileNames: "js/[name].js",
				assetFileNames: ({ name }) => {
					if (/\.js$/.test(name ?? "")) {
                        // return "assets/js/[name]-[hash][extname]";
                        return "js/[name][extname]";
                    }
					if (/\.css$/.test(name ?? "")) {
						// return "assets/css/[name]-[hash][extname]";
						return "css/[name][extname]";
					}
					// default value
					// ref: https://rollupjs.org/guide/en/#outputassetfilenames
					return "assets/[name]-[hash][extname]";
				},
			},
		},
	}, // ...
});
