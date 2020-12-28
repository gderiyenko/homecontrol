<template>
  <div>
    <div class="card">
      <div class="card-header">
        <span> Runner </span>
      </div>

      <div class="card-body">
        <v-card v-for="command in commands" :key="command.id" class="m-3">
          <v-card-title class="headline">{{command.name}}</v-card-title>
          <v-card-subtitle>{{command.description}}</v-card-subtitle>
          <v-card-text>
            <div v-if="command.input">
              <v-text-field v-model="command.inputValue" label="input" required></v-text-field>
            </div>
            <h6>on {{command.object.name}} computer</h6>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              class="ma-2"
              :loading="loading"
              :disabled="loading"
              dark
              @click="run(command)"
            >
              Run
              <v-icon
                small
              >
                mdi-play
              </v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </div>
    </div>

    <!-- Failed action notification -->
    <v-snackbar v-model="snackbar">
      {{ text }}

      <template v-slot:action="{ attrs }">
        <v-btn color="red" text v-bind="attrs" @click="snackbar = false">
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
import { mdiDotsVertical } from "@mdi/js";

export default {
  name: "Runner",
  data() {
    return {
      // List.
      commands: [],

      // Failed notification.
      snackbar: false,
      text: `Action failed. Try again later.`,
    };
  },

  created() {
    this.getCommands();
  },

  methods: {
    /**
     * Get all user's commands.
     */
    getCommands() {
      axios
        .get("/commands")
        .then((response) => {
          this.commands = response.data.data;
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {});
    },

    /**
     * Get all user's commands.
     */
    run(command) {
      axios
        .post("/command/"+command.id+"/run", {
          input: command.inputValue ?? ""
        })
        .then((response) => {
          
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {});
    },
  },
};
</script>