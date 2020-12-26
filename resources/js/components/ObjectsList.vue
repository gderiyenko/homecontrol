<template>
  <div>
    <div class="card">
      <div class="card-header">
        <span> Objects </span>
        <div class="float-right">
          <v-btn color="primary" dark @click="dialog = true"> Add </v-btn>
        </div>
      </div>

      <div class="card-body">
        <v-simple-table>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">Name</th>
                <th class="text-left">Connection</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in objects" :key="item.name">
                <td>{{ item.name }}</td>
                <td>{{ item.details }}</td>
                <td class="text-right">
                  <v-icon> mdi-dots-vertical</v-icon>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </div>
    </div>
    <!-- Add object modal window -->
    <v-dialog v-model="dialog" max-width="600">
      <v-card>
        <v-card-title class="headline"> Create object </v-card-title>

        <v-card-subtitle>
          Input here your new object's settings for future connections. The
          object may be a RaspberryPi device or any other Unix-based computer.
        </v-card-subtitle>

        <v-card-text>
          <v-text-field v-model="name" label="Name" required></v-text-field>
          <v-text-field v-model="ip" label="IP" required></v-text-field>
          <v-text-field
            v-model="username"
            label="Username"
            required
          ></v-text-field>
          <v-text-field v-model="port" label="Port" required></v-text-field>
          <v-text-field
            v-model="keypass"
            label="password"
            required
          ></v-text-field>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text v-on:click="sendForm()">
            Add
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- -->
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
  name: "ObjectsList",
  data() {
    return {
      // List
      objects: [],

      // Add Form
      dialog: false,
      name: "",
      ip: "",
      username: "",
      port: "",
      keypass: "",

      // Failed notification
      snackbar: false,
      text: `Action failed. Try again later.`,
    };
  },

  created() {
    this.getObjects();
  },

  methods: {
    /**
     * Get all user's objects.
     */
    getObjects() {
      axios
        .get("/objects")
        .then((response) => {
          this.objects = response.data.data;
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {});
    },
    /**
     * Send Add Object Form.
     */
    sendForm() {
      this.loading = true;
      axios
        .post("/object", {
          name: this.name,
          ip: this.ip,
          username: this.username,
          port: this.port,
          keypass: this.keypass,
        })
        .then((response) => {
          console.log(response.data)
          if (response.data.success) {
            // Push to Objects.
            this.objects.push(response.data.object);

            // Reset values.
            this.name = "";
            this.ip = "";
            this.username = "";
            this.port = "";
            this.keypass = "";
          } else {
            this.snackbar = true;
          }
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          // Close modal.
          this.dialog = false;
        });
    },
  },
};
</script>