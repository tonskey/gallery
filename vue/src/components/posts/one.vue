<template>
<div v-if="post" class="row">
	<div class="col-md-12">
		<h1>{{post.title}}</h1>
		<div class="row">
			<div class="col-md-10 info-post">
				<span class="usernick created">
					<strong>
						<span class="glyphicon glyphicon-user"></span>
						<em>{{post.owner.name}}</em>
					</strong>
				</span>
				<span class="created">
					<span class="glyphicon glyphicon-calendar"></span>
					{{ from(post.createdAt)}}		
				</span>
				<span class="created">
					<span class="glyphicon glyphicon-eye-open"></span>
					{{post.views}}
				</span>
			</div>	
		</div>
		<div class="row">
			<div class="col-md-10">
				<hr>
				<p class="text-justify">
					{{post.body}}
				</p>
			</div>
		</div>
		<div v-if="post.comments" class="row">
			<div class="col-md-7">
				<h3>
					<span class="glyphicon glyphicon-comment"></span>
					Comments ({{post.comments.length}})
				</h3>
				<template v-if="user">
						<textarea
							v-model="newcomment" 
							placeholder="What you think about this?" 
							class="form-control" 
							rows="4"
						>		
						</textarea>
						<br>
						<button @click.prevent="send_newcomment" class="btn btn-lg btn-primary">
							<span class="glyphicon glyphicon-send"></span>
							Send
						</button>
					<hr>
				</template>
				<template v-for="comment in post.comments">
					<div class="row">
						<div class="col-md-12">
							<div >
							<template v-if="comment.author.id==user.data.id">
								<button 
									@click.prevent="deleteComment(comment)" 
									class="btn btn-danger"
								>
									<span class="glyphicon glyphicon-trash"></span>
								</button>
								<button @click="editcom(comment)" class="btn btn-warning">
									<span class="glyphicon glyphicon-edit"></span>
								</button>
							</template>
								<span style="color:green">
									{{comment.popul}}
								</span>
							</div>
							<div>
								<a href="#">
									{{comment.author.name}}
								</a>
								<br>
								<p v-if="editcomment!=comment">
									{{comment.body}}
								</p>
								<template v-else >
									<textarea
										rows="4" 
										v-model="comment.body"
									>										
									</textarea>
									<br>
									<button @click="savecomment(comment)" class="btn btn-sm btn-success">
										<span class="glyphicon glyphicon-save"></span>
										Save comment
									</button>
									<button 
										@click.prevent="cancelEdit(comment)" 
										class="btn btn-sm btn-default"
									>
										Cancel edit
									</button>
								</template>
								<p>
									{{new Date(comment.createdAt).toString()}}	
								</p>									
							</div>	
							<div style="clear:both"></div>
						</div>
					</div>
					<hr>
				</template>
			</div>	
		</div>
	</div>
</div>

</template>
<script>
export default {
	name: 'post.one',
	data (){
		return{
			newcomment:null,
			post:null,
			editcomment:null,
			cashcomment:null
		}
	},
	computed:{
		user(){
			return this.$store.getters.user;
		},
	},
	methods:{
		editcom(comment)
		{
			this.editcomment=comment;
			this.cashcomment=comment.body;
		},	
		getPost(id)
		{
			this.$http
			.get('posts/'+id)
			.then(function(response){
				this.post=response.data;
				this.$store.dispatch('setTitle',`${this.post.title} - ${this.post.owner.name}`);
				let flag=false,
					self=this;
				this.$store.getters.user.favor.forEach(function(favor){
					if(favor.id==self.post.id){
						flag=true;
					}
				})
				this.$set(this.post,'isFavor',flag)

			})
		},
		from(str)
		{
			return this.$moment(str).fromNow();
		},
		favor()
		{
			this.post.isFavor=!this.post.isFavor;
			if(this.post.isFavor){
				this.$store.dispatch('addFavor',this.post);
			}else{
				this.$store.dispatch('deleteFavor',this.post);
			}
		},
		send_newcomment()
		{
			if(!this.newcomment)return;

			let self=this;
			this.$http
			.post('comments',{
				body:self.newcomment,
				popul:0,
				post:self.post.id,
				author:self.$store.getters.user.data.id
			})
			.then(function(response){
				console.log(response.data.author);
				console.log(response.data.author.id);
				console.log(self.$store.getters.user.data.id);
				self.post.comments.push(response.data);
				self.newcomment=null;
			})
		},
		savecomment(comment)
		{
			this.editcomment=null;
			let self=this;
			this.$http
			.put('comments/'+comment.id,{body:comment.body})
			.then(function(res){
				console.log(res);
			},function(err){
				console.log(err);
			})

		},
		deleteComment(comment)
		{
			let self=this;
			this.$http
			.delete('comments/'+comment.id)
			.then(function(res){
				console.log('no err');
				self.post.comments.splice(self.post.comments.indexOf(comment),1);
			},function(err){
				console.log(err);
			})
		},
		cancelEdit(comment){
			comment.body=this.cashcomment;
			this.editcomment=null;
		}

	},
	created(){
		this.getPost(this.$route.params.id);
	}
};
</script>

<style lang="css" scoped>
	.usernick{
		font-size: 17px;		
	}
	.usernick strong{
		cursor: pointer;
	}
	.usernick strong:hover{
		color:#337ab7;
	}
	.usernick:hover .shot-info{
		display: block;
	}
	.info-post{
		margin-left:10px;
		padding:10px;
		border:1px solid black;
	}
	.shot-info{
		position: absolute;
		border:1px solid black;
		padding:10px;
		border-color: #858585;
		background-color: white;
		display: none;
		font-size:14px;
		margin-top:-3px;
		z-index: 9999;
	}
	.created{
		margin-right: 20px;
	}
</style>