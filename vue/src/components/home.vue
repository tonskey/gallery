<template>
<div class="row">
	<div class="col-md-9">
		<template v-if="pictures">
			<a  
				:disabled="sortDir=='asc'?true:false"
				@click.prevent="sort('asc')" 
				href="#"
			>
				Asc
			</a> | 
			<a 
				:disabled="sortDir=='desc'?true:false"
				@click.prevent="sort('desc')" 
				href="#"
			>
				Desc
			</a>
			<ul class="media-list">
				<template v-for="picture in pictures">	
				<li class="media" >
					<div class="media-left">
						<router-link :to="{name:'picture',params:{id:picture.id}}">
							<img 
								class="media-object thumbnail img-thumbnail" 
								:src="picture.thumb" 
								:alt="picture.title"
							>	
						</router-link>	
					</div>
					<div class="media-body">
						<router-link :to="{name:'picture',params:{id:picture.id}}">
							<h4 class="media-heading">{{picture.title}}</h4>
						</router-link>	
						{{picture.description.substr(0,100)}}
						<br>
						<strong>Created: {{picture.created_at}}</strong>
						<template v-if="user">
							<br>
							<button class="btn btn-danger" 
								@click.prevent="del(picture)">
								<span class="glyphicon glyphicon-trash"></span>
								Delete
							</button>
							<router-link
								class="btn btn-warning" 
								:to="{name:'update',params:{id:picture.id}}"
							>
								<span class="glyphicon glyphicon-edit">
								</span>
								Edit
							</router-link>	
						</template>
					</div>
				</li>
				<hr>
				</template>
			</ul>
			<div class="pagination">
				<button 
					class="btn btn-default" 
					@click="getPictures(pagination.prev)"
					:disabled="!pagination.prev"
				>
				Previous				
				</button>
				<span>Page {{pagination.cur}} of {{pagination.last}}</span>
				<button 
					class="btn btn-default" 
					@click="getPictures(pagination.next)"
					:disabled="!pagination.next"
				>
				Next				
				</button>
			</div>
		</template>	
	</div>
</div>
</template>
<script type="text/javascript">
	export default{
		name:'home',
		data(){
			return {
				pictures:null,
				sortDir:'desc',
				pagination:{},
			}
		},
		methods:{
			sort(dir)
			{
				this.sortDir=dir;
				this.getPictures();
			},
			getPictures(page=1)
			{
				this.$http
				.get(`/p?dir=${this.sortDir}&page=${page}`)
				.then(function(response){
					this.pictures=response.data.data;
					this.paginate(response.data);
				})
			},
			paginate(res)
			{
				this.pagination={
					cur:res.current_page,
					last:res.last_page,
				};
				if(res.next_page_url)
				this.pagination.next=res.next_page_url[res.next_page_url.length-1];
				if(res.prev_page_url)
				this.pagination.prev=res.prev_page_url[res.prev_page_url.length-1];
			},
			del(p)
			{
				this.pictures.splice(this.pictures.indexOf(p),1);
				this.$http
				.delete('/p/'+p.id)
				.then(
					()=>{},
					(err)=>{
						console.log(err);
					}
				)
			}
		},
		created(){
			this.getPictures();
		},	
		computed:{
			user(){
				return this.$store.getters.user;
			},
		}

	}
</script>