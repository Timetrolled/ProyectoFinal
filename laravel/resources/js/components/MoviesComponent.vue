<template>
<div>
 <button class="btn btn-primary" @click='getResult()'>Mas populares</button>
<div class="row gx-4 gx-lg-5 justify-content-center">
    <div class="card movie_card" v-for='result in results' :key='result.id'>
        <img
            :src="'http://image.tmdb.org/t/p/w500'+result.poster_path"
            class="card-img-top"
            alt="..."
        />
        <span>{{a(result)}}</span>
        <div class="card-body">
            <h5 class="card-title">{{result.title}}</h5>
            <span class="movie_info">{{result.release_date.split("-")[0]}}</span>
            <span class="movie_info float-right"
                ><i class="fas fa-star"></i> {{result.vote_average}} / 10</span
            >
        </div>
    </div>
   </div>
</div> 
</template>

<script>
export default {
    data:function () {
        return{
            results: '',
        }
    },
    created() {
        console.log(this.movie);
    },
    methods: {
        getResult(query) {
            axios.get('https://api.themoviedb.org/3/movie/popular?api_key=9ec647bcf53f9315ac4f7e4e2322c906&page=1').then(response => { this.results = response.data.results })
        },
        a(movie){
           return console.log(movie)
        },
   
 }
};
</script>
