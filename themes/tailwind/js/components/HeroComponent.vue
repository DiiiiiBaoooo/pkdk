<template>
    <section class="hero">
        <img :src="getAssetUrl('image/slider1.png')" alt="" style="mix-blend-mode: multiply" />
      <h2 class="text-center text-xl font-semibold mt-4 text-red-600">
        Chung tay cùng cộng đồng đẩy lùi dịch Sars-CoV-2
      </h2>
    </section>
  </template>
  
  <script>
  export default {
    name: "HeroComponent",
    methods: {
        getAssetUrl(path) {
            return `/${path}`; // hoặc dùng `/` nếu asset để public
        }
    }
  };
  </script>
  
  <style scoped>
  .hero {
    text-align: center;
    padding: 20px;
  }
  </style>
  