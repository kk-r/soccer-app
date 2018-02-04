<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Teams
                    </div>

                    <div class="panel-body">
                        <ul class="list-group" v-if="teams.length>0">
                            <li class="list-group-item list-group-item-action"
                                :class="isActive(team)"
                                v-for="(team,index) in teams">
                                <img class="img-thumbnail" width="100" :src="team.logo_url || 'http://via.placeholder.com/100?text=Dummy+Team+Pic'" alt="">
                                {{team.name}}
                                <button @click="edit(team)" type="button" class="btn btn-info    btn-xs pull-right">
                                    Edit
                                </button> &nbsp;
                                <button @click="deleteItem(team,index)" type="button"
                                        class="btn btn-warning btn-xs pull-right">

                                    <template v-if="team.deleteButtonLoader">
                                        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Deleting Team
                                    </template>

                                    <template v-else>
                                        Delete
                                    </template>

                                </button>

                                <p class="label label-danger" v-if="team.notfound">This team not found!! Please reload</p>
                                <p class="label label-danger" v-if="team.pagerefresh">This page expired!! Please reload</p>

                            </li>
                        </ul>
                        <p v-else>
                            No Teams available
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{isCreate ? 'Edit' : 'Create'}} Team
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

                        <div class="alert alert-danger" role="alert" v-if="error_message">
                            <button type="button" class="close" @click="closeSuccess">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <p>{{error_message}}</p>
                        </div>


                        <div class="alert alert-success" role="alert" v-if="success_message">
                            <button type="button" class="close" @click="closeSuccess">
                                <span aria-hidden="true">&times;</span>
                            </button>
                           <p>{{success_message}}</p>
                        </div>

                        <form v-on:submit.prevent="save">
                            <div class="form-group">
                                <label>Team Name</label>
                                <input maxlength="100" v-model="team.name" type="text" class="form-control"
                                       placeholder="Enter Team name">
                                <small id="emailHelp" class="form-text text-muted">We'll use this team name for your
                                    team
                                </small>
                            </div>
                            <div class="form-group">
                                <label>Team Logo</label>
                                <input maxlength="200" v-model="team.logo_url" type="url" class="form-control"
                                       placeholder="Enter Team logo url">
                                <small id="logoHelp" class="form-text text-muted">We'll show this logo for branding
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary">

                                <template v-if="saveButtonLoader">
                                    <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>  {{isCreate ? 'Updating' : 'Creating'}} Team
                                </template>

                                <template v-else>
                                    {{isCreate ? 'Update' : 'Create'}} Team
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
    const API_URL = '/api/teams/';

    export default {
        mounted() {
            this.loadList()
        },
        data() {
            return {
                teams: [],
                team: {},
                saveButtonLoader: false,
                validation_errors:null,
                success_message:null,
                error_message: null,
            }
        },
        computed: {
            isCreate() {
                return this.team.id
            }
        },
        methods: {
            loadList() {
                axios.get(API_URL).then((response) => {
                    this.teams = response.data.data;
                }).catch((response) => {
                    console.error(response);
                })
            },
            edit(item) {
                this.closeAlert()
                this.team = Object.assign({}, item)
            },
            create() {
                this.closeAlert();
                this.team = {}
            },
            closeAlert() {
                this.closeSuccess();
                this.validation_errors = null
            },
            closeSuccess() {
                this.success_message = null
                this.error_message = null
            },
            resetItem() {
                this.team = {}
            },
            isActive(item) {
                return this.team.id === item.id ? 'active' : '';
            },
            save() {
                this.closeAlert()
                let method = "POST";
                let api = API_URL;
                if (this.team.id) {
                    method = "PUT";
                    api += this.team.id
                }
                if (typeof this.team.logo_url === "undefined") {
                    this.team.logo_url = "";
                }
                let fetchData = {
                    method: method,
                    url: api,
                    data: this.team
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
            deleteItem(item,index) {
                let that = this;

                let canDelete = confirm("Are you sure to delete team " + item.name + " ? ");
                if(canDelete) {
                    Vue.set(this.teams[index], 'deleteButtonLoader', true)
                    this.closeAlert()
                    let fetchData = {
                        method: "DELETE",
                        url: API_URL + item.id,
                    };

                    let ind = index;
                    axios(fetchData).then((response) => {
                        this.loadList();
                    }).catch((err) => {
                        let response = err.response;

                        if (response.status === 404) {
                            Vue.set(that.teams[index], 'notfound', true)
                            Vue.set(that.teams[index], 'deleteButtonLoader', false)
                        }

                        if (response.status === 419) {
                            Vue.set(that.teams[index], 'pagerefresh', true)
                            Vue.set(that.teams[index], 'deleteButtonLoader', false)
                        }

                    })
                }
            }
        }
    }
</script>

