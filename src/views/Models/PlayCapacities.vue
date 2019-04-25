<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div>
    <!--<model-table modelName="Language" :columns="columns" :filterfunction="filterfunction">-->
    <model-table modelName="PlayCapacity" :columns="columns" :key="recalcKey">
      <!--suppress HtmlUnknownBooleanAttribute -->
      <template v-slot:head>
        Sitzplätze
      </template>
      <!--<template v-slot:actionButtons></template>-->
      <template v-slot:name="{ row }">{{ row.name }}</template>
      <template v-slot:seats="{ row }">
        <span class="icon" v-if="!calcSeats(row.id)">
          <i class="fas fa-spinner fa-pulse"></i>
        </span>
        <span class="tag is-success" v-else>{{ calcSeats(row.id) }}</span>
      </template>
      <template v-slot:editor="{ editData }">
        <play-capacity-edit
          :editData="editData"
          modelName="PlayCapacity"
        ></play-capacity-edit>
        <!--@changesSaved="recalcKey++"-->
      </template>
    </model-table>
  </div>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";
import ModelTable from "@/views/Models/common/ModelTable.vue";
import PlayCapacityEdit from "@/views/Models/PlayCapacityEdit.vue";
import {PlayCapacityrowType, PlayCapacityType} from "@/shared/store/models";

export default Vue.extend({
  components: {
    PlayCapacityEdit,
    ModelTable
  },
  data() {
    return {
      recalcKey: 0,
      columns: [
        {
          field: "name",
          label: "Name"
        },
        {
          field: "remarks",
          label: "Bemerkung",
          sortable: false
        },
        {
          label: "Plätze",
          customKey: "seats"
        }
      ]
    };
  },
  computed: {
    capacityrows(): PlayCapacityrowType[] {
      return this.$store.getters["models/model"]("PlayCapacityrow");
    },
    /* calcSeats_older() {
         return this.capacityrows
          ? this.capacityrows
              .reduce(
                (a, r) => {
                  if (!a[r.play_capacity_id]) {
                    a[r.play_capacity_id] = [0, 0];
                  }
                  let z = a[r.play_capacity_id];
                  z[0] = z[0] + Math.min(r.adults, r.juniors);
                  z[1] = z[1] + Math.max(r.adults, r.juniors);
                  return a;
                },
                { 0: [0, 0] }
              )
              .map(a => {
                let z = a.value;
                return z[0] + z[1] === 0 ? false : z[0] + ".." + z[1];
              })
          : [];
      }
    */
  },
  methods: {
    filterfunction: (model: any) => {
      return model.id > 2;
    },
    calcSeats(capacityID: number) {
      let arr = this.capacityrows.reduce(
        (a: [number, number], r: PlayCapacityrowType) => {
          if (r.play_capacity_id === capacityID) {
            a[0] = a[0] + Math.min(r.adults, r.juniors);
            a[1] = a[1] + Math.max(r.adults, r.juniors);
          }
          return a;
        },
        [0, 0]
      );
      return arr[0] + arr[1] === 0 ? false : arr[0] + ".." + arr[1];
    }
  },
  created() {
    this.$store.dispatch("models/load", { model: "PlayCapacityrow" });
  }
});
</script>

<style scoped></style>
