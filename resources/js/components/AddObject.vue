<template>
  <div>
    <v-btn color="primary" dark @click="dialog = true"> Add </v-btn>

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
          <v-btn color="green darken-1" text v-on:click="sendForm()"> Add </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  name: "AddObject",
  data() {
    return {
      dialog: false,
      loading: false,

      name: "",
      ip: "",
      username: "",
      port: 0,
      keypass: "",
    };
  },

  methods: {
    onResponse(result) {
      if (result === true) {
        this.dialog = false;
      } else {
        console.log("failed");
      }
    },
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
          onResponse(response.data.success);
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
};
</script>