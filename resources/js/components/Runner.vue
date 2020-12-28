<template>
  <div>
    <div class="card">
      <div class="card-header">
        <span> Runner </span>
      </div>

      <div class="card-body">
        <v-card v-for="command in commands" :key="command.id">
          <h4>{{command.name}}</h4>
          <p>{{command.description}}</p>
          <div v-if="command.input">
            <v-text-field v-model="command.customInput" label="input" required></v-text-field>
          </div>
          <h6>{{command.object.name}}</h6>
          <v-btn
            class="ma-2"
            :loading="loading"
            :disabled="loading"
            dark
            @click="run(item)"
          >
            Run
            <v-icon
              small
            >
              mdi-play
            </v-icon>
          </v-btn>
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
        .get("/run/" + command.id)
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