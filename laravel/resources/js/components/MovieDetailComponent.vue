<template>
<div class="container-fluid">
    <div id="detail" class="container" v-if="movie">
        <div class="row justify-content-center">
                    <div class="card-body row d-flex flex-row">
                        <div class="col-sm-6 col-lg-4">
                        <img id="portada" :src="'http://image.tmdb.org/t/p/w500' + this.movie.poster_path">
                        </div>
                        
                        <div class="col-xs-12 col-sm-6 col-lg-8 mt-4">
                            <h1 id="title" class="d-flex flex-row justify-content-between">{{this.movie.title}}</h1>
                            <span id="genre" v-for="genre in this.movie.genres">{{genre.name}} </span>
                            <span id="date"><i class="far fa-calendar-alt ms-1 me-1" ></i>{{this.movie.release_date.split("-")[0]}}</span>
                            <span id="time" class="ms-2"><i class="far fa-clock"></i>{{this.movie.runtime}}min</span>
                            <p id="review">{{this.movie.overview}}</p>

                        <div v-if="watchProviders">
                            <div class="providers" v-if="watchProviders.flatrate">
                                <span class="rentStreamBuy me-2">Streaming</span>
                                    <span class="ms-2" v-for="provider in (this.watchProviders.flatrate)">

                                        <img class="me-2" width="40px":src="'http://image.tmdb.org/t/p/original' + provider.logo_path" alt="">
                                        {{provider.provider_name}}
                                    </span>
                            </div>
                            <div class="providers" v-if="watchProviders.rent">
                                <span class="rentStreamBuy me-2">Alquiler</span>
                                    <span class="ms-2" v-for="provider in (this.watchProviders.rent)">

                                        <img class="me-2" width="40px":src="'http://image.tmdb.org/t/p/original' + provider.logo_path" alt="">
                                        {{provider.provider_name}}
                                    </span>
                            </div>
                        </div>

                        <div v-if="logged" id="addRemoveFromList" class="btn btn-lg mt-4" @click="addRemoveFromList">
                            <span>Añadir a la lista</span>
                            
                            <img v-if="!inList" class="ms-2" src="../../images/emptyHeart.png" width="25px" alt="">
                            <img v-if="inList" id="heart" class="ms-2" src="../../images/heart.png" width="25px" alt="">
                        </div>

                        </div>

                        <div v-if="videoResults" class="mt-4 d-flex align-items-center justify-content-center">
                            <iframe width="650" height="415" :src="'https://www.youtube.com/embed/'+this.videoResults[0].key" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        
                         
                        
                    </div>
        </div>
    </div>
    
</div>
</template>

<script>

export default {
    props: ["id"],
    data: function() {
        return {
            userId: '',
            logged: false,
            movie: null,
            videoResults : null,
            watchProviders: null,
            videoLoaded:false,
            providersLoaded:false,
            inList:false,
            prueba:false,
        };
    },
    mounted() {
        this.movieBasicJson();
        this.movieWatchProviders();
        this.movieVideoJson();
        this.checkUserID();
        this.checkFilmInList();
    },
    methods: {
        checkFilmInList(){
            axios.get("/addFilm/"+this.id)
            .then(response => {
                   this.output = response.data
                   this.inList = this.output.exists;
                   }
            );
        },
        addRemoveFromList(){
            axios.post("/addFilm/"+this.id)
            .then(response => {
                   this.output = response.data
                //    this.inList = this.output.exists;
                    this.inList = this.output.exists;
                }
            );
        },
        checkUserID(){
            axios.get('/is-auth')
            .then(response => {
                if(response.data) {
                    if (response.data.id) {
                        console.log(response.data);
                        this.userId = response.data.id;
                        this.logged = true;
                    }
                }
            })
        },
        movieBasicJson() {
            axios
                .get(
                    "https://api.themoviedb.org/3/movie/"+this.id+"?api_key=9ec647bcf53f9315ac4f7e4e2322c906&language=es-ES"
                )
                .then(response => {
                    this.movie = response.data;
                });
        },
        movieVideoJson(){
            axios.get("https://api.themoviedb.org/3/movie/"+this.id+"/videos?api_key=9ec647bcf53f9315ac4f7e4e2322c906&language=en-US")
            .then(response =>{
                this.videoResults = response.data.results;
                this.videoLoaded = true;
            });
        },
        async movieWatchProviders(){
            const test2 = await axios.get("https://api.themoviedb.org/3/movie/"+this.id+"/watch/providers?api_key=9ec647bcf53f9315ac4f7e4e2322c906")
            .then(response =>{
                this.watchProviders = response.data.results['ES'];
                this.providersLoaded = true;               
            });
        }
    },
    computed:{
        inListStyle: function(){
            return{
                'inList' : this.inList,
            }
        },
    },
};

</script>
<style>


.rentStreamBuy{
    color:#e4d804;
}
#backdrop {
    width: 100%;
}
#detail {
    padding-top: 10rem;
   
}

.providers{
    padding:25px 10px;
    background-color: #1d1b292f;
    border: 1px solid rgba(255, 255, 255, 0.041);
    color: white;
    font-size: 13px;
}

#addRemoveFromList{
    background-color: #e4d804;
    color: rgb(0, 0, 0);
    font-size: 13px;
    border-radius: 5px;
}



.notInList{
    color: grey !important;
}
.inList{
    color: #fb3640 !important;
}

#title{
    color: white;
    font-weight: 900;
}

#genre{
    color: #E50914;
    font-weight: 300;
    font-size: 13px;
}
.fa-calendar-alt{
    color:#e4d804;
    font-size: 12px;
}
.fa-clock{
    color:#e4d804;
    font-size: 12px;
}
#date{
    color: rgba(255, 255, 255, 0.753);
    font-weight: 300;
    font-size: 13px;
}

#time{
     color: rgba(255, 255, 255, 0.753);
    font-weight: 300;
    font-size: 13px;
}

#review{
    color: rgba(255, 255, 255, 0.753);
    font-weight: 300;
    font-size: 0.9rem;
}


#portada{
    width: 80%;
}

#heart{
    animation: heartbeat 1s;
}


@keyframes heartbeat
{
  0%
  {
    transform: scale( .75 );
  }
  20%
  {
    transform: scale( 1 );
  }
  40%
  {
    transform: scale( .75 );
  }
  60%
  {
    transform: scale( 1 );
  }
  80%
  {
    transform: scale( .75 );
  }
  100%
  {
    transform: scale( .75 );
  }
}


@media (max-width: 575px) {
    #portada{
        width: 100%;
    }
}

</style>
