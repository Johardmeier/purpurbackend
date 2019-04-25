<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div>
    <!--<model-table modelName="Language" :columns="columns" :filterfunction="filterfunction">-->
    <model-table modelName="PlayPricestructure" :columns="columns">
      <!--suppress HtmlUnknownBooleanAttribute -->
      <template v-slot:head>
        Preismodelle
      </template>
      <!--<template v-slot:actionButtons></template>-->
      <template v-slot:reduction-count="{ row }">
        {{ reductionCounts[row.id] }}
      </template>
      <template v-slot:editor="{ editData }">
        <price-structure-edit
          :editData="editData"
          modelName="PlayPricestructure"
        ></price-structure-edit>
      </template>
    </model-table>
  </div>
</template>

<!--suppress TypeScriptUnresolvedFunction -->
<script lang="ts">
import Vue, { Component } from "vue";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";
import ModelTable from "@/views/Models/common/ModelTable.vue";
import PriceStructureEdit from "@/views/Models/PriceStructureEdit.vue";

export default Vue.extend({
  components: {
    PriceStructureEdit,
    ModelTable
  },
  data() {
    return {
      waitForLoaded: true,
      columns: [
        {
          field: "name",
          label: "Preismodell"
        },
        {
          field: "remarks",
          label: "Bemerkungen",
          sortable: true
        },
        {
          field: "adult_price",
          label: "Preis Erwachsene",
          sortable: true
        },
        {
          field: "junior_price",
          label: "Preis Kinder",
          sortable: true
        },
        {
          customKey: "reduction-count",
          label: "Reduktionen",
          sortable: true
        }
      ]
    };
  },
  computed: {
    reductionCounts(): {} {
      if (this.waitForLoaded) return {};
      return [
        ...this.$store.getters["models/model"]("PlayPricediscountJunior"),
        ...this.$store.getters["models/model"]("PlayPricediscountAdult"),
        ...this.$store.getters["models/model"]("PlayPricediscountGroup")
      ].reduce(function(a, { pricestructure_id: id }) {
        a[id] ? a[id]++ : (a[id] = 1);
        return a;
      }, {});
    }
  },
  methods: {
    filterfunction: (model: any) => {
      return model.id > 2;
    }
  },
  created() {
    Promise.all([
      this.$store.dispatch("models/load", { model: "PlayPricediscountJunior" }),
      this.$store.dispatch("models/load", { model: "PlayPricediscountAdult" }),
      this.$store.dispatch("models/load", { model: "PlayPricediscountGroup" })
    ]).then(() => (this.waitForLoaded = false));
  }
});
</script>

<style scoped></style>
