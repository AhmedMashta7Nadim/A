import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel(
            ['resources/js/app.jsx']
        
        ),
        react(),
    ],
});


// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import tailwindcss from '@tailwindcss/vite';
// import vue from '@vitejs/plugin-vue';

// import react from '@vitejs/plugin-react';
// export default defineConfig({
//     plugins: [
//         laravel(
//             [ 'resources/js/app.js'],
//             react()
//         ),
//         vue(),
//         tailwindcss(),
//     ],
// });
