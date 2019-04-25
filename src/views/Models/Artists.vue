<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div>
    <model-table modelName="Artist" :columns="columns">
      <template v-slot:head>Künstlerverwaltung</template>
      <template v-slot:editor="{ editData }">
        <artist-edit :editData="editData" modelName="Artist"></artist-edit>
      </template>
    </model-table>
  </div>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";
import ModelTable from "@/views/Models/common/ModelTable.vue";
import ArtistEdit from "@/views/Models/ArtistEdit.vue";

export default Vue.extend({
  components: {
    ArtistEdit,
    ModelTable
  },
  data() {
    return {
      columns: [
        {
          field: "name",
          label: "Name"
        },
        {
          field: "url",
          label: "Webseite",
        }
      ]
    };
  },
  computed: {},
  methods: {},
  created() {}
});
</script>

<style scoped></style>
