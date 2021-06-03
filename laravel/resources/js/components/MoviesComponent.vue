<template>
    <div>
        <div id="botonera d-flex flex-row">
            <button
                class="p2 btnText btn btn-outline-dark mr-md-3 mb-2 mb-md-0"
                @click="getPopular()"
            >
                Mas populares
            </button>
            <button
                class="p2 btnText btn btn-outline-dark mr-md-3 mb-2 mb-md-0"
                @click="getTrending()"
            >
                Popular hoy
            </button>


            
            <input type="text" id="searchButton" class="btnText btn btn-outline-dark mr-md-3 mb-2 mb-md-0" placeholder="Buscar" v-model="query" @keyup="getResults()">
            



        </div>
        
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div
                class="card movie_card"
                v-for="result in results"
                :key="result.id"
            >
                <img
                    :src="'http://image.tmdb.org/t/p/w500' + result.poster_path"
                    class="card-img-top"
                    alt="..."
                />
                <div class="card-body">
                    <h6 class="card-title">{{ result.title }}</h6>
                    <span class="movie_info ml-3">{{
                        result.release_date.split("-")[0]
                    }}</span>
                    <span class="movie_info float-right"
                        ><i class="fas fa-star"></i> {{ result.vote_average }} /
                        10</span
                    >
                </div>
            </div>
        </div>

        <div class="mt-4 text-white d-flex align-items-center justify-content-center">
        </div>

    </div>
</template>

<script>
export default {
    data: function() {
        return {
            results: '',
            query:''
        };
    },
    created() {
        this.initialList();
    },
    methods: {
        initialList(){
            axios
                .get(
                    "https://api.themoviedb.org/3/movie/popular?api_key=9ec647bcf53f9315ac4f7e4e2322c906&page=1"
                )
                .then(response => {
                    this.results = response.data.results;
                });
        },
        getPopular() {
            this.firstText = '',
            this.query = '';
            axios
                .get(
                    "https://api.themoviedb.org/3/movie/popular?api_key=9ec647bcf53f9315ac4f7e4e2322c906&page=1"
                )
                .then(response => {
                    this.results = response.data.results;
                });
        },
        getTrending() {
            this.firstText = '',
            this.query = '';
            axios
                .get(
                    "https://api.themoviedb.org/3/trending/movie/day?api_key=9ec647bcf53f9315ac4f7e4e2322c906"
                )
                .then(response => {
                    this.results = response.data.results;
                });
        },
        getResults(){
            this.firstText = '',
            axios
                .get(
                    "https://api.themoviedb.org/3/search/movie?api_key=9ec647bcf53f9315ac4f7e4e2322c906&language=es-ES&query="+this.query+"&page=1&include_adult=false"
                )
                .then(response => {
                    this.results = response.data.results;
                });
        }
    }
};
</script>
