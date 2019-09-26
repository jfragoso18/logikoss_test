<template>
  <v-app>
    <v-app-bar app>
      <v-toolbar-title class="headline">
        <span>
          Inicio /
          <strong>Usuarios</strong>
        </span>
      </v-toolbar-title>
    </v-app-bar>

    <v-content>
      <v-card>
        <v-card-title>
          Actual users
          <v-btn color="primary" @click="createUser()">Crear usuario</v-btn>
          <div class="flex-grow-1"></div>

          <v-text-field
            v-model="search"
            append-icon="search"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-data-table :headers="headers" :items="users" :search="search">
          <template v-slot:item.action="{ item }">
            <v-icon small class="mr-2" @click="console.log('About to edit')">remove_red_eye</v-icon>
            <v-icon small class="mr-2" @click="console.log('About to edit')">edit</v-icon>
            <v-icon small @click="console.log('About to delete')">delete</v-icon>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-left">{{ props.item.id }}</td>
            <td class="text-xs-left">{{ props.item.name }}</td>
            <td class="text-xs-center">{{ props.item.email }}</td>
          </template>
          <template v-slot:item.avatar="{}">
            <img src="@/assets/default.png" width="30" height="30" alt srcset />
          </template>
          <template v-slot:item.birthday="{}">
            <p>18 de Agosto</p>
          </template>
        </v-data-table>
      </v-card>
    </v-content>
  </v-app>
</template>

<script>
import axios from "axios";

export default {
  name: "App",
  components: {},
  data() {
    return {
      search: "",
      headers: [
        { text: "Acciones", value: "action" },
        { text: "ID", value: "id" },
        { text: "Nombre", value: "name" },
        { text: "Correo", value: "email" },
        { text: "Avatar", value: "avatar" },
        { text: "Cumpleaños", value: "birthday" }
      ],
      users: [
        {
          id: 1,
          name: "Jesús Fragoso",
          email: "jesus.fragoso@correo.mx",
          avatar: "storage/...",
          birthday: "18/09/1994"
        }
      ]
    };
  },
  async created() {
    try {
      let users = await axios.get("http://localhost:8000/api/user");
      if (users) {
        this.users = users.data.data;
        console.log(users);
      }
    } catch (error) {
      console.log(error);
    }
  },
  methods: {
    async createUser() {
      try {
        let temp = Math.round(new Date().getTime()/1000);
        let user = await axios.post("http://localhost:8000/api/user", {
          name: "Ejemplo " + temp,
          password: 'secret',
          email: "ejemplo" + temp + "@gmail.com",
          username: '__ejemplo__' + temp,
        });
        if ( user ) {
          console.log("Registrado con éxito");
          console.log(user.data.data);
        }
      } catch (error) {
        console.log("Ha ocurrido un error");
        
      }
    }
  }
};
</script>

<style>
* {
  font-family: "Ubuntu", sans-serif;
}
</style>

