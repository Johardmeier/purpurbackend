<template>
  <model-edit-form :editData="editData" :modelName="modelName" @close="$parent.close()">
    <template v-slot="{ data, currentModel }">
      <b-field label="Name">
        <b-input v-model="data.name" placeholder="Anna Blume" required></b-input>
      </b-field>
      <b-field label="Webseite">
        <b-input v-model="data.url" placeholder="http://theater-purpur.ch"></b-input>
      </b-field>
    </template>
  </model-edit-form>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";
import ModelEditForm from "@/views/Models/common/ModelEditForm.vue";

export default Vue.extend({
  name: "ArtistEdit",
  components: { ModelEditForm },
  props: {
    editData: Object,
    modelName: String
  }
});
</script>
<style scoped></style>
