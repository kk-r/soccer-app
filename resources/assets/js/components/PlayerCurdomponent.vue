<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Players
                    </div>

                    <div class="panel-body">
                        <ul class="list-group" v-if="players.length>0">
                            <li class="list-group-item list-group-item-action"
                                :class="isActive(player)"
                                v-for="(player,index) in players">
                                <img class="img-thumbnail" width="100" :src="player.logo_url || 'http://via.placeholder.com/100?text=Dummy+Player+Pic'" alt="">
                                {{player.first_name}} {{player.last_name}}
                                <button @click="edit(player)" type="button" class="btn btn-info    btn-xs pull-right">
                                    Edit
                                </button> &nbsp;
                                <button @click="deleteItem(player,index)" type="button"
                                        class="btn btn-warning btn-xs pull-right">

                                    <template v-if="player.deleteButtonLoader">
                                        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>
                                        Deleting Team
                                    </template>

                                    <template v-else>
                                        Delete
                                    </template>


                                </button>
                                <p class="label label-danger" v-if="player.notfound">This Player removed!! Please reload</p>
                                <p class="label label-danger" v-if="player.pagerefresh">This page expired!! Please reload</p>
                            </li>

                        </ul>
                        <p v-else>

                            No Players available

                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{isCreate ? 'Edit' : 'Create'}} Player
                        <button v-if="isCreate" @click="create()" type="button"
                                class="btn btn-primary btn-xs pull-right">Create
                        </button>
                    </div>

                    <div class="panel-body">

                        <div class="alert alert-danger" role="alert" v-if="validation_errors">
                            <button type="button" class="close" @click="closeAlert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul>
                                <li v-for="err in validation_errors">{{err[0]}}</li>
                            </ul>

                        </div>

                        <div class="alert alert-success" role="alert" v-if="success_message">
                            <button type="button" class="close" @click="closeSuccess">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <p>{{success_message}}</p>
                        </div>

                        <div class="alert alert-danger" role="alert" v-if="error_message">
                            <button type="button" class="close" @click="closeSuccess">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <p>{{error_message}}</p>
                        </div>

                        <form v-on:submit.prevent="save">
                            <div class="form-group">
                                <label>First Name</label>
                                <input maxlength="100" v-model="player.first_name" type="text" class="form-control"
                                       placeholder="Enter player first name">
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input maxlength="100" v-model="player.last_name" type="text" class="form-control"
                                       placeholder="Enter player last name">
                            </div>
                            <div class="form-group">
                                <label>Player Logo</label>
                                <input maxlength="200" v-model="player.logo_url" type="text" class="form-control"
                                       placeholder="Enter Player logo url">
                                <small id="logoHelp" class="form-text text-muted">We'll show this logo for branding
                                </small>
                            </div>

                            <div class="form-group">
                                <label>Choose a Team</label>
                                <select v-model="player.team_id" class="form-control">
                                    <option value=""></option>
                                    <option v-for="team in teams" v-bind:value="team.id">{{team.name}}</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <template v-if="saveButtonLoader">
                                    <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>
                                    {{isCreate ? 'Updating' : 'Creating'}} Player
                                </template>

                                <template v-else>
                                    {{isCreate ? 'Update' : 'Create'}} Player
                                </template>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const API_URL = '/api/players/';
    const API_TEAM_URL = '/api/teams/';

    export default {
        mounted() {
            this.loadList()
        },
        data() {
            return {
                players: [],
                player: {},
                file: '',
                teams: [],
                saveButtonLoader: false,
                validation_errors: null,
                success_message: null,
                error_message: null,
            }
        },
        computed: {
            isCreate() {
                return this.player.id
            }
        },
        methods: {
            loadList() {

                axios.get(API_URL).then((response) => {
                    this.players = response.data.data;
                }).catch((response) => {
                    console.error(response);
                })

                axios.get(API_TEAM_URL).then((response) => {
                    this.teams = response.data.data;
                }).catch((response) => {
                    console.error(response);
                })
            },
            edit(item) {
                this.closeAlert()
                this.player = Object.assign({}, item)
            },
            create() {
                this.closeAlert();
                this.player = {}
            },
            isActive(item) {
                return this.player.id === item.id ? 'active' : '';
            },
            closeAlert() {
                this.validation_errors = null
            },
            closeSuccess() {
                this.success_message = null
            },
            resetItem() {
                this.player = {}
            },
            save() {
                this.closeAlert()
                let method = "POST";
                let api = API_URL;
                if (this.player.id) {
                    method = "PUT"
                    api += this.player.id
                }
                if (typeof this.player.logo_url === "undefined") {
                    this.player.logo_url = "";
                }
                if (typeof this.player.team_id === "undefined") {
                    this.player.team_id = "";
                }
                let fetchData = {
                    method: method,
                    url: api,
                    data: this.player
                };


                this.saveButtonLoader = true;
                axios(fetchData).then((response) => {
                    this.teams = response.data.data;
                    this.success_message = response.data.status.message;
                    this.saveButtonLoader = false;
                    this.loadList();
                    this.resetItem();
                }).catch((err) => {
                    this.saveButtonLoader = false;
                    let response = err.response;

                    if (response.status === 404) {
                        this.error_message = response.data.status.message;
                    }
                    if (response.status === 419) {
                        this.error_message = "Page expired. Please refresh";
                    }
                    if(response.status===422){
                        this.validation_errors = response.data.data.validation_errors;
                    }

                })
            },
            deleteItem(item, index) {
                let that =this;
                let canDelete = confirm("Are you sure to delete player " + item.first_name + " ? ");
                if(canDelete){
                    Vue.set(this.players[index], 'deleteButtonLoader', true)

                    item.deleteButtonLoader = true;
                    this.closeAlert()
                    let fetchData = {
                        method: "DELETE",
                        url: API_URL + item.id,
                    };
                    axios(fetchData).then((response) => {
                        this.loadList();
                    }).catch((err) => {
                        let response = err.response;
                        if (response.status === 404) {
                            Vue.set(that.players[index], 'notfound', true)
                            Vue.set(that.players[index], 'deleteButtonLoader', false)
                        }
                        if (response.status === 419) {
                            Vue.set(that.players[index], 'pagerefresh', true)
                            Vue.set(that.players[index], 'deleteButtonLoader', false)
                        }
                    })
                }

            }
        }
    }
</script>
