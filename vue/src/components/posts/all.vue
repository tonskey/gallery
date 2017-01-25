<template>
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>
					NEW POST
					<small>
						Allways best	
					</small>
				</h1>
			</div>
			<div class="row">
				<div class="col-md-8">
					<template v-if="posts" v-for="post in posts" >			
						<div class="row">
							<div class="col-md-12">
								<h3 style="margin-top:0px">
									<router-link :to="{name:'post',params:{id:post.id}}">
										{{post.title}}
									</router-link>	
								</h3> 
								<span style="color:#777;font-size:14px">
									{{from(post.createdAt)}}
								</span>
								<br>
								<p class="text-justify">
									{{post.body.substr(0,300)}}...
								</p>
								<p>
									<strong>{{post.owner.name}}</strong>  |
									<span>
										<span class="glyphicon glyphicon-eye-open"></span>
										{{post.views}}
									</span>   |
									<span>
										<span class="glyphicon glyphicon-comment"></span>
										{{post.comments.length}}
									</span>  |
									<template v-if="user">
						 				<template v-if="post.isFavor">
											<a @click.prevent="toogleFavor(post)" href=""> 
												Delete from favorite
											</a>
										</template>
										<template v-else>
											<a @click.prevent="toogleFavor(post)" href="">
												 Add to favorite
											</a>										
										</template> 
										<template v-if="user.data.id==post.owner.id">
											<router-link :to="{name:'updatepost',params:{id:post.id}}">
												<span class="glyphicon glyphicon-edit">
												</span>
												Edit
											</router-link>	
											<button @click.prevent="deletepost(post)" class="btn btn-sm btn-danger">
												<span class="glyphicon glyphicon-remove"></span>
												Delete
											</button>											
										</template>
									</template>
								</p>
							</div>
						</div>
						<br>						
					</template>		
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-8 col-md-offset-4 ">
							Sort by 
							<a @click.prevent="sort('title')" href="">title</a>, 
							<a @click.prevent="sort('createdAt')" href="">time</a>
							<a @click.prevent="sort('views')" href="">views</a>						
						</div>				
					</div>				
				</div>	
			</div>	
			<nav v-if="posts" aria-label="Page navigation">
				<ul class="pagination">
					<li v-bind:class="{disabled:pagination.currentPage==1}">
						<a @click.prevent.stop="getPosts(pagination.currentPage-1)" href="" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						</a>
					</li>
					<template v-for="page in pagination.max">
						<li v-bind:class="{active:pagination.currentPage==page}">
							<a @click.prevent.stop="getPosts(page)" href="">{{page}}</a>
						</li>
					</template>
					<li v-bind:class="{disabled:pagination.currentPage==pagination.max}">
						<a @click.prevent.stop="getPosts(pagination.currentPage+1)" href="" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
						</a>
					</li>
				</ul>
			</nav>	
		</div>	
	</div>	
</template>
<script type="text/javascript">
	export default {
		name:'posts.all',
		data(){
			return {
				posts:null,
				currentSort:"createdAt",
				pagination:{
					currentPage:1,
					max:null,
				}
				
			}
		},
		computed:{
			user(){
				return this.$store.getters.user;
			},
		},
		created(){
			this.$store.dispatch('setTitle',`Posts`);
			this.getPosts(this.pagination.currentPage);
		},
		methods:{
			getPosts(topage,sort)
			{
				if(sort){
					this.currentSort=sort;
				}
				console.log(topage);
				if(topage<1){
					console.log('error <1')
					return;
				}else if(this.pagination.max!=null&&topage>this.pagination.max){
					console.log('error >max')
					return;
				}
				console.log('success');
				let query=`posts?page=${topage}&sort=${this.currentSort}`;
				console.log(query);
				this.$http
				.get(query)
				.then((response)=>{
					this.posts=(response.data.posts);
					this.pagination.currentPage=topage;
					this.pagination.max=Math.ceil(response.data.count);
					let self=this;
					for(let post of this.posts)
					{
						let flag=false
						for(let f of self.$store.getters.user.favor)
						{
							if(f.id==post.id)flag=true;
						}
						self.$set(post,'isFavor',flag);
					}
				})
			},
			from(str)
			{
				return this.$moment(str).fromNow();
			},
			toogleFavor(favor)
			{
				favor.isFavor=!favor.isFavor;
				if(favor.isFavor){
					this.$store.dispatch('addFavor',favor);
				}else{
					this.$store.dispatch('deleteFavor',favor);
				}
			},
			sort(field)
			{
				this.getPosts(1,field);
			},
			deletepost(post)
			{
				let self=this;
				console.log(post.id);
				this.$http
				.delete('posts/'+post.id)
				.then(function(result){
					console.log(result);
					self.posts.splice(self.posts.indexOf(post),1);
				},function(err){
					console.log(err);
				})
			}
		}
	}
</script>