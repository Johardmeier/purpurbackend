<template>
  <model-edit-form :editData="editData" :modelName="modelName" @close="$parent.close()" style="width: 90vw">
    <template v-slot="{ data, currentModel }">
      <div class="columns is-multiline">
        <div class="column is-half">
          <b-field label="Name"><b-input v-model="data.name" placeholder="Anna Blume" required></b-input></b-field>
          <b-field label="Beschreibung"><b-input type="textarea" v-model="data.description" placeholder="Anna Blume" required></b-input></b-field>
          <b-field label="Infos zur Produktion"><b-input  type="textarea" v-model="data.production_infos" placeholder="" required></b-input></b-field>
        </div>
        <div class="column is-half">
          <b-field label="Bild"><b-input v-model="data.image" placeholder="Anna Blume" required></b-input></b-field>
          <img src="http:\\ppp_data.test/images/test/jo.jpg">

        </div>
        <div class="column is-one-quarter">
          <b-field label="Name">
            <b-select placeholder="Künstler">
              <option
                v-for="artist in artists"
                :value="artist.id"
                :key="artist.id">
                {{ artist.name }}
              </option>
            </b-select>
          </b-field>
        </div>
        <div class="column is-one-quarter">
          <b-field label="Alter"><b-input v-model="data.min_age" type="number" required></b-input></b-field>
          <b-field label="Dauer"><b-input v-model="data.duration" type="number" required></b-input></b-field>
        </div>
        <div class="column is-one-quarter">
          <b-field label="Preise"><b-input v-model="data.pricestructure_id" required></b-input></b-field>
          <b-field label="Plätze"><b-input v-model="data.capacity_id" required></b-input></b-field>
          <b-field label="Sprache"><b-input v-model="data.language_id" required></b-input></b-field>
        </div>
        <div class="column is-one-quarter">
          <b-field label="Zusatztext Webseite"><b-input v-model="data.additional_webpage_message" type="textarea" placeholder="" required></b-input></b-field>
          <b-field label="Bemerkungen"><b-input v-model="data.remarks" type="textarea" placeholder="" required></b-input></b-field>
        </div>
      </div>
    </template>
  </model-edit-form>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";
import ModelEditForm from "@/views/Models/common/ModelEditForm.vue";

export default Vue.extend({
  name: "PlayEdit",
  components: { ModelEditForm },
  props: {
    editData: Object,
    modelName: String
  },
  computed: {
    artists(): {} {
      return this.$store.getters["models/model"]("Artist");
    }
  }
});
</script>
<style scoped></style>
