

<template>
 <div class="row">
	<aside class="col-4">
<div class="card">
	<article class="card-group-item">
		<header class="card-header">
			<h6 class="title">Categories </h6>
		</header>
		<div class="filter-content">
			<div class="card-body">
			<div>
				<div class="checkbox-filter">
								<div v-for="(category,index) in categories" :key="index" class="form-check">
									<input  type="checkbox" class="form-check-input" @change="getData()" :value="category.id" v-model="selectedCategories" :id="'category_' + index">
									<label class="form-check-label" :for="category.id">
									
										{{category.name}}
									</label>
								</div>
								
							</div>
	
			</div>

			</div> <!-- card-body.// -->
		</div>
	</article> <!-- card-group-item.// -->
	</div>
  </aside>
  <div class="col-8">
   <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Books</th>
            <th>Author Name</th>
            <th>Category</th>
            <th>Publish Date</th>
            </tr>
        </thead>
            <tbody>
              <tr v-for="book in books.data" :key="book.id">
              <td>{{book.title}}</td>
              <td>{{book.author_name}}</td>
              <td>{{book.category}}</td>
              <td>{{book.publish_date}}</td>
              </tr>
           </tbody>
       </table>
       </div>
        
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
      selectedCategories: [],
    }
  },
  methods : {
    getData() {
      console.log('helo');
       axios.get('/api/data' 
       + '/?selectedCategories=' + this.selectedCategories.toString()).then(response => {
        this.books = response.data;
        this.categories = response.data.categories;
            }).catch(err => console.log(err));
    },
  
  },
  watch:{
        sortby: function(){
            this.getData();
        },
        },
  mounted() {
    this.getData();
  }
}
</script>

