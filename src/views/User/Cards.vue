<template>
  <div class="columns is-multiline is-variable is-centerd is-gapless">
    <div class="column" v-for="(user, index) in users" v-bind:key="index">
      <div class="card usercard">
        <div
          class="card-header has-background-paperblue has-text-white"
          v-bind:class="{ 'has-background-paperred': editableItem === index }"
        >
          <div class="card-header-title  has-text-white">{{ user.name }}</div>
          <span class="card-header-icon" v-if="editableItem === index">
            <span v-on:click="cancelChanges()">
              <b-icon pack="fas" icon="times-circle" size="is-small" />
            </span>
            <span v-on:click="submitChanges(index)">
              <b-icon pack="fas" icon="check-circle" size="is-small" />
            </span>
          </span>
          <span class="card-header-icon" v-on:click="selectUser(index)" v-else>
            <b-icon pack="fas" icon="edit" size="is-small" />
          </span>
        </div>
        <div class="card-content">
          <div class="media">
            <div class="media-left">
              <figure class="image is-48x48">
                <img
                  :src="user.image"
                  alt="Placeholder image"
                  v-if="user.image"
                />
                <b-icon pack="fas" icon="user" size="is-large" v-else />
              </figure>
            </div>
            <div class="media-content">
              <p class="title is-4">{{ user.fullname }}</p>
              <p class="subtitle is-6">
                <b-icon pack="far" icon="envelope" size="is-small"></b-icon>
                {{ user.email }}
              </p>
            </div>
          </div>
          <div class="content" v-if="editableItem === index">
            <b-field label="Roles">
              <b-taginput
                v-model="user.roles"
                :data="availableRoles(index)"
                autocomplete
                field="name"
                type="is-paperred"
                open-on-focus
                rounded
              ></b-taginput>
            </b-field>
            <div class="buttons is-right ">
              <span class="button is-small" v-on:click="newPassword()">
                Reset Password
              </span>
              <span class="button is-small" v-on:click="changeEmail()">
                Change Email
              </span>
            </div>
          </div>
          <div class="content" v-else>
            <b-field label="Roles">
              <b-taginput
                v-model="user.roles"
                field="name"
                type="is-paperblue"
                rounded
                :closable="false"
                disabled
              ></b-taginput>
            </b-field>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
import { apiService, ppApiUser } from "@/shared/services";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";

export default Vue.extend({
  data() {
    return {
      users: [{}] as ppApiUser[],
      defaultOpenedDetails: [1],
      roleTags: [],
      editableItem: -1
    };
  },
  computed: {},
  methods: {
    selectUser(userIndex: number) {
      if (this.editableItem === -1) {
        this.editableItem = userIndex;
      } else {
        Toast.open({
          message: "unsaved Changes @" + this.users[this.editableItem].name,
          type: "is-warning"
        });
      }
    },
    availableRoles(userIndex: number) {
      return this.roleTags.filter(
        item => !this.users[userIndex].roles.some(r => r === item)
      );
    },
    cancelChanges() {
      this.getUsers();
      this.editableItem = -1;
    },
    submitChanges(userIndex: number) {
      let payload = {
        id: this.users[userIndex].id,
        roles: this.users[userIndex].roles
      };
      apiService.postData("/users/roles", payload);
      this.editableItem = -1;
    },
    newPassword() {
      //TODO:: implement
    },
    changeEmail() {
      //TODO:: implement
    },
    getUsers() {
      apiService.getData("/users").then(u => {
        this.users = u;
      });
    },
    getRoles() {
      apiService.getData("/options",).then(u => {
        this.roleTags = u.roles;
      });
    }
  },
  created() {
    this.getUsers();
    this.getRoles();
  }
});
</script>
<style scoped lang="scss">
.usercard {
  border-radius: 6px;
  margin: 2rem;
  width: 22rem;
  img {
    border-radius: 2rem;
    /*border: #c75d16 solid 4px;*/
  }
}
.card-header-icon {
  cursor: auto;
  span {
    span {
      cursor: pointer;
      margin-left: 0.5rem;
    }
  }
}
</style>
