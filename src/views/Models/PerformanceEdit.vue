<template>
  <form action="">
    <div class="modal-card" style="width: auto">
      <header class="modal-card-head">
        <p class="modal-card-title">{{ editedLanguage.name }}</p>
      </header>
      <section class="modal-card-body">
        <b-field label="Name">
          <b-input
            v-model="editedLanguage.name"
            placeholder="Schwizerdütch"
            required>
          </b-input>
        </b-field>

        <b-field label="Kürzel">
          <b-input
            v-model="editedLanguage.short"
            placeholder="sd"
          >
          </b-input>
        </b-field>
      </section>
      <footer class="modal-card-foot">
        <button class="button" type="button" @click="saveArtist">Speichern</button>
        <button class="button" type="button" @click="$parent.close()">Abbrechen</button>
      </footer>
    </div>
  </form>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";


export default Vue.extend({
  name: "LanguageEdit",
  props: {
    editData: Object,
    modelName: String
  },
  data() {
    return {
//      editedLanguage: { ...this.language }
    };
  },
  computed: {
    //TODO:: Make this safe. @tM we just check if there's a name Property...
    isNew() {
//      return !this.language.name;
    }
    //editedLanguage() {return { ...this.artist}}
  },
  methods: {
/*
    saveArtist() {
      let actionPath = "models/" + (this.isNew ? "new" : "modify");
      this.$store.dispatch(actionPath, { model: "Language", data: this.editedLanguage });
      //@ts-ignore
      this.$parent.close();
    }
*/
  }
});
</script>

<style scoped></style>
