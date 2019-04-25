<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png" />{{ $route.meta.title }}
  </div>
</template>

<script>
export default {
  name: "Placeholder",
  props: ["Placeholdertext"],
  data() {
    return {
      place: "test"
    };
  }
};
</script>
