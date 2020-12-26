<template>
  <div>
    <v-list-group
      v-for="item in groups"
      :key="item.object_id"
      no-action
      sub-group
    >
      <template v-slot:activator>
        <v-list-item-content>
          <v-list-item-title>{{ item.object_name }}</v-list-item-title>
        </v-list-item-content>
      </template>

      <v-list-item v-for="command in item.commands" :key="command.id">
        <v-card class="m-2 w-100">
          <v-toolbar color="indigo" dark>
            <v-toolbar-title>{{ command.name }}</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn icon>
              <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
          </v-toolbar>

          <v-card-subtitle>{{ command.description }}</v-card-subtitle>
          <v-card-text>
            <v-text-field v-if="command.input" label="Input"></v-text-field>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn outlined rounded text> Run </v-btn>
          </v-card-actions>
        </v-card>
      </v-list-item>
    </v-list-group>
  </div>
</template>

<script>
import { mdiDotsVertical } from "@mdi/js";

export default {
  name: "CommandsList",
  data() {
    return {
      groups: [],
    };
  },

  created() {
    this.getCommands();
  },

  methods: {
    onResponse(result) {
      console.log(result);
      this.groups = result;
    },
    getCommands() {
      axios
        .get("/commands")
        .then((response) => {
          this.groups = response.data.data;
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {});
    },
  },
};
</script>