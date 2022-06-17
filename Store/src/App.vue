<script setup>
import { RouterLink, RouterView } from 'vue-router'


</script>

<template>
<div>
  <nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom">
    <a class="navbar-brand ml-2 font-weight-bold" href="#">FORCEPAUSED</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor" aria-controls="navbarColor" aria-expanded="false" aria-label="Toggle navigation"> 
        <span class="navbar-toggler-icon"></span> 
    </button>
    <div class="collapse navbar-collapse" id="navbarColor">
        <ul class="navbar-nav">
            <li class="nav-item"><router-link class="nav-link" :to="{name: 'home'}">Home</router-link> </li>
            <li class="nav-item"> <router-link class="nav-link"  :to="{name: 'categories'}">Categories</router-link>  </li>                
            <li class="nav-item "><router-link class="nav-link" :to="{name: 'books'}">Books</router-link> </li>
        </ul>        
    </div>
     <ul class="nav navbar-nav navbar-right">
      <li class="nav-item"><router-link class="nav-link" v-if="!isLoggedIn" :to="{name: 'login'}">Login</router-link></li>
      <li class="nav-item"><router-link class="nav-link" v-if="!isLoggedIn" :to="{name: 'register'}">Register</router-link></li>
      <li class="nav-item"><a class="nav-link" @click="logout()" v-if="isLoggedIn">Logout</a></li>


    </ul>
 </nav>
 


  <RouterView />
  </div>
</template>
<script>
import axios from 'axios'
export default {
  data() {
    return {
      isLoggedIn: JSON.parse(localStorage.getItem('logged')) || false,
      categories: {},
      books : {},
    }
  },
  methods : {
  
     logout() {
        this.isLoggedIn = false;
        localStorage.removeItem('logged');
      console.log('hello');
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('api/logout').then(res => {

                        if (res.data.message) {
                          console.log("hello logout");
                        
                          this.$router.go('/');

                        } else {
                            console.log(res);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
    });
    }
  },
 
}
</script>

