<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div>
    <model-table modelName="Play" :columns="columns">
      <template v-slot:head>TODO:: Stücke</template>
      <!--<template v-slot:actionButtons></template>-->
      <!--<template v-slot:name="{ row }">{{ row.name }}</template>-->
      <template v-slot:editor="{ editData }">
        <play-edit
          :editData="editData"
          modelName="Play"
        ></play-edit>
      </template>
    </model-table>
  </div>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";
import ModelTable from "@/views/Models/common/ModelTable.vue";
import PlayEdit from "@/views/Models/PlayEdit.vue";

export default Vue.extend({
  components: {
    PlayEdit,
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
          field: "image",
          label: "Bild",
          sortable: true
        },
        {
          field: "description",
          label: "Beschreibung",
          sortable: false
        },
        {
          field: "production_infos",
          label: "Infos zur Produktion",
          sortable: false,
          visible: false
        },
        {
          field: "min_age",
          label: "Alter",
          sortable: true
        },
        {
          field: "duration",
          label: "Dauer",
          sortable: true
        },
        {
          field: "artist",
          label: "Künstler",
          sortable: true
        },
// Erste Aufführung, letzte Aufführung, ....
      ]
    };
  },
  computed: {},
  methods: {
    filterfunction: (model: any) => {
      return model.id > 2;
    }
  },
  created() {}
});
</script>

<style scoped></style>
