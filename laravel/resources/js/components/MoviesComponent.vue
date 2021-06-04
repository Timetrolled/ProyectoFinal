<template>
    <div>
        <div id="botonera d-flex">
            <button
                class="p2 btnText btn btn-outline-dark mr-md-3 mb-2 mb-md-0"
                @click="changeActualState('popular');initialGetPopular()"
            >
                Mas populares
            </button>
            <button
                class="p2 btnText btn btn-outline-dark mr-md-3 mb-2 mb-md-0"
                @click="changeActualState('trending');initialGetTrending()"
            >
                Popular hoy
            </button>


            
            <input type="text" id="searchButton" class="ml-auto btnText btn btn-outline-dark mr-md-3 mb-2 mb-md-0" placeholder="Buscar" v-model="query" @keyup="changeActualState('searchQuery');initialGetResults()">
            



        </div>
        
        <div class="row gx-4 gx-lg-5 justify-content-center">
            
            <div
                class="card movie_card"
                v-for="result in results"
                :key="result.id"
            >
            <a :href="'/details/' + result.id">
                <img
                    :src="'http://image.tmdb.org/t/p/w500' + result.poster_path"
                    class="card-img-top"
                    alt="..."
                />
                </a>
                <div class="card-body">
                    <h6 class="card-title">{{ result.title }}</h6>
                    <span class="movie_info ml-3">{{result.release_date | dateFormat}}</span>
                    <span class="movie_info float-right"
                        ><i class="fas fa-star"></i> {{ result.vote_average }} /
                        10</span
                    >
                </div>
            </div>
            <div v-if="actualState === 'initialList'">
                <infinite-loading @infinite="initialList"></infinite-loading>
            </div>
            <div v-else-if="actualState === 'popular'">
                <infinite-loading @infinite="getPopular"></infinite-loading>
            </div>
            <div v-else-if="actualState === 'trending'">
                <infinite-loading @infinite="getTrending"></infinite-loading>
            </div>
            <div v-else-if="actualState === 'searchQuery'">
                <infinite-loading @infinite="getResults"></infinite-loading>
            </div>
            
        </div>

        <div class="mt-4 text-white d-flex align-items-center justify-content-center">
        </div>

    </div>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';

export default {
    components: {
        InfiniteLoading,
    },
    data: function() {
        return {
            actualState:'initialList',
            results: [],
            query:'',
            page:1,
        };
    },
    filters:{
        dateFormat($value){
            // console.log($value);
            if ($value) {
                
                return $value.split("-")[0];
            }
        },
    },
    methods: {
        changeActualState($actual){
            this.actualState = $actual;
        },
        initialList($state){
            axios
                .get(
                    "https://api.themoviedb.org/3/movie/popular?api_key=9ec647bcf53f9315ac4f7e4e2322c906&page="+this.page
                )
                .then(response => {
                    if (response.data.results.length) {
                        this.page += 1;
                        this.results.push(...response.data.results);
                        $state.loaded();
                        console.log(this.page);
                    }else{
                        $state.complete();
                    }
                });
        },
        initialGetPopular(){
            this.firstText = '';
            this.query = '';
            this.actualState = 'popular';
            axios
                .get(
                    "https://api.themoviedb.org/3/movie/popular?api_key=9ec647bcf53f9315ac4f7e4e2322c906&page=1"
                )
                .then(response => {
                   this.results = response.data.results;
                });
        },
        getPopular($state) {
            this.firstText = '';
            this.query = '';
            this.actualState = 'popular';
            axios
                .get(
                    "https://api.themoviedb.org/3/movie/popular?api_key=9ec647bcf53f9315ac4f7e4e2322c906&page="+this.page
                )
                .then(response => {
                     if (response.data.results.length) {
                        this.page += 1;
                        this.results.push(...response.data.results);
                        $state.loaded();
                        console.log(this.page);
                    }else{
                        $state.complete();
                    }
                });
        },
        initialGetTrending() {
            this.firstText = '';
            this.query = '';
            this.actualState = 'trending';
            axios
                .get(
                    "https://api.themoviedb.org/3/trending/movie/day?api_key=9ec647bcf53f9315ac4f7e4e2322c906"
                )
                .then(response => {
                    this.results = response.data.results;
                });
        },
        getTrending($state) {
            this.firstText = '';
            this.query = '';
            this.actualState = 'trending';
            axios
                .get(
                    "https://api.themoviedb.org/3/trending/movie/day?api_key=9ec647bcf53f9315ac4f7e4e2322c906&page="+this.page
                )
                .then(response => {
                    if (response.data.results.length) {
                        this.page += 1;
                        this.results.push(...response.data.results);
                        $state.loaded();
                        console.log(this.page);
                    }else{
                        $state.complete();
                    }
                });
        },
        initialGetResults(){
            this.firstText = '';
            this.actualState = 'searchQuery';
            axios
                .get(
                    "https://api.themoviedb.org/3/search/movie?api_key=9ec647bcf53f9315ac4f7e4e2322c906&language=es-ES&query="+this.query+"&include_adult=false"
                )
                .then(response => {
                    this.results = response.data.results;
                });
        },
        getResults($state){
            this.firstText = '';
            this.actualState = 'searchQuery';
            axios
                .get(
                    "https://api.themoviedb.org/3/search/movie?api_key=9ec647bcf53f9315ac4f7e4e2322c906&language=es-ES&query="+this.query+"&include_adult=false&page="+this.page
                )
                .then(response => {
                    if (response.data.results.length) {
                        this.page += 1;
                        this.results.push(...response.data.results);
                        $state.loaded();
                        console.log(this.page);
                    }else{
                        $state.complete();
                    }
                });
        }
    }
};
</script>
