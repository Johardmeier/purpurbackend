<template>
  <div>
    <button class="button is-medium is-primary" @click="showEditForm = true">Launch imageInput (default)
    </button>
    <b-modal :active.sync="showEditForm" has-modal-card :canCancel="false" width="100%" >
      <image-input></image-input>
    </b-modal>
  </div>
</template>

<script>
import imageInput from "./imageInput";

export default {
  name: "testInput",
  components: {imageInput},
  data() {
    return {
      showEditForm: false,
    }
  }
};
</script>

<style scoped></style>
