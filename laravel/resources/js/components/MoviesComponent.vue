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
            
            <v-select v-model="genre" @input="getFilmsByGenre" label="name" :options="genres" class="me-2 ms-2 mr-md-3 mb-2 mb-md-0" placeholder="Género">

            </v-select>

            <button v-if="logged" @click="getListFilms" class="p2 btnText btn btn-outline-warning mr-md-3 mb-2 mb-md-0">Mi lista <i class="fas fa-heart ms-2"></i></button>


        </div>
        
        <div class="row gx-4 gx-lg-5 justify-content-center">
            
            <div
                class="card movie_card"
                v-for="result in results"
                :key="result.id"
            >
            <a :href="'/details/' + result.id">
                <img v-if="result.poster_path"
                    :src="'http://image.tmdb.org/t/p/w500/' + result.poster_path"
                    class="card-img-top"
                    alt="..."
                />
                <img class="card-img-top" v-else src="https://linkilaw.com/wp-content/uploads/2019/11/img-placeholder.jpg" alt="">
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
            <div v-else-if="actualState === 'genres'">
                <infinite-loading @infinite="getFilmsByGenreInfinite"></infinite-loading>
            </div>
            
        </div>

        <div class="mt-4 text-white d-flex align-items-center justify-content-center">
        </div>

    </div>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
import 'vue-select/dist/vue-select.css';

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
            logged:false,
            userId: '',
            userFilms:[],
            genres:[],
            genre: null,
            once:0,
        };
    },
    mounted(){
        this.checkLogin();
        this.getGenres();
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
        getFilmsByGenre(){
            this.once++;
            console.log(this.once);
            
            this.results = [];
            
            console.log(JSON.parse(JSON.stringify(this.genre)));
            this.actualState = 'genres';
            this.changeActualState('genres');
            axios
                .get(
                    "https://api.themoviedb.org/3/discover/movie?api_key=9ec647bcf53f9315ac4f7e4e2322c906&with_genres="+this.genre.id+"&page="+this.page
                )
                .then(response => {
                    this.results.push(response.data);
                    this.results.shift();
                });
        },
        getFilmsByGenreInfinite($state){
            this.firstText = '';
            this.query = '';
            this.actualState = 'genres';
            axios
                .get(
                    "https://api.themoviedb.org/3/discover/movie?api_key=9ec647bcf53f9315ac4f7e4e2322c906&with_genres="+this.genre.id+"&page="+this.page
                )
                .then(response => {
                     if (response.data.results.length) {
                        this.page += 1;
                        this.results.push(...response.data.results);
                        this.once++;
                        $state.loaded();
                    }else{
                        $state.complete();
                    }
                });
        },
        getGenres(){
            axios.get('https://api.themoviedb.org/3/genre/movie/list?api_key=9ec647bcf53f9315ac4f7e4e2322c906&language=es-ES')
            .then(response => {
                this.genres.push(...response.data.genres);
            });
        },
        getListFilms(){
            this.actualState = "";
            this.results = [];
            console.log(this.userFilms);
            this.userFilms.forEach(pelicula => {
                axios
                .get(
                    "https://api.themoviedb.org/3/movie/"+pelicula.film_id+"?api_key=9ec647bcf53f9315ac4f7e4e2322c906&language=es-ES"
                )
                .then(response => {
                    this.results.push(response.data);
                });
            });
        },
        checkLogin(){
            axios.get('is-auth')
            .then(response => {
                if(response.data) {
                    // console.log(response.data);
                    this.logged = true;
                    this.userId = response.data.id;
                    axios.get('/user/'+this.userId)
                    .then(userResponse => {
                        if(userResponse.data) {
                        this.userFilms = userResponse.data;
                        }
                    })
                }else{
                    // console.log("not logged in");
                    this.logged = false;
                }
            })
        },
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
            console.log(this.results);
            axios
                .get(
                    "https://api.themoviedb.org/3/search/movie?api_key=9ec647bcf53f9315ac4f7e4e2322c906&language=es-ES&query="+this.query+"&include_adult=false&page="+this.page
                )
                .then(response => {
                    if (response.data.results.length) {
                        this.page += 1;
                        this.results.push(...response.data.results);
                        $state.loaded();
                    }else{
                        $state.complete();
                    }
                });
        }
    }
};
</script>
<style>
.fa-heart{
    color: #fb3640;
}


.v-select {
    display: inline-block;
    width: 200px;
}

.vs__search{
    color: #fb3640;
}

.vs__selected{
    color: #fb3640;
}


</style>