<template>
  <section>
    <div class="third"><h1>This is third page</h1></div>
    <button class="button block" @click="isActive = !isActive">Toggle</button>
    <b-message title="Default" :active.sync="isActive">Testmessage</b-message>
  </section>
</template>

<script>
export default {
  name: "Third",
  data() {
    return {
      isActive: true
    };
  }
};
</script>
