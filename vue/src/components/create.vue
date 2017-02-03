<template>
	<div class="row">
		<h1 class="text-center">Add picture</h1>
		<div class="col-md-7 col-md-offset-1">
			<div v-if="block.error" class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Oh snap!</strong> {{block.error}}
			</div>
			<div v-if="block.success" class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Well done!</strong> {{block.success}}
			</div>
			<form class="form-horizontal">
				<div class="form-group">
					<input type="file" @change="file">
					<img 
						v-if="preview" 
						:src="preview" 
						width="540"
						class="img img-thumbnail" 
						height="380"
					>
				</div>
				<div class="form-group" :class="{'has-error': errors.has('title') }">
					<label class="col-sm-2 control-label">Title</label>
					<div class="col-sm-10">
						<input
							v-model="newpost.title"
							data-vv-rules="required|min:3" 
							v-validate
							type="text"
							name="title"
							class="form-control"
							placeholder="Title"
						>
						<p class="text-danger" v-if="errors.has('title')">
							{{errors.first('title')}}
						</p>
					</div>
				</div>
				<div class="form-group" :class="{'has-error': errors.has('body') }">
					<label class="col-sm-2 control-label">Description</label>
					<div class="col-sm-10">
						<textarea
							v-model="newpost.body"
							data-vv-rules="required|min:3" 
							v-validate
							name="body"
							placeholder="Description" 
							class="form-control" 
							rows="4"
						>		
						</textarea>
						<p class="text-danger" v-if="errors.has('body')">
							{{errors.first('body')}}
						</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button 
							type="submit" 
							@click.prevent="add" 
							class="btn btn-success"
						>
							Add picture
						</button>
					</div>
				</div>
			</form>
		</div>		
	</div>
</template>
<script>
export default {
  	name: 'create',
  	data () {
    	return {
    		newpost:{
    			title:null,
    			body:null,
    			img:null
    		},
    		block:{
    			error:null,
    			success:null
    		},
    		preview:null
    	};
  	},
  	created(){
		this.$store.dispatch('setTitle',`Add picture`);
  	},
  	methods:{
  		add()
  		{  		
  			if(this.errors.errors.length!=0||
  				this.newpost.img==null||
  				this.newpost.body==null||
  				this.newpost.title==null
  				)
  			{
  				this.block.success=null;
  				this.block.error='You have error in some field';
  				return;
  			};
  			console.log(this.$validator);
  			console.log(this.errors);
  			let post=new FormData();
  			post.append('title',this.newpost.title);
  			post.append('description',this.newpost.body);
  			post.append('img',this.newpost.img);
  			this.$http
  			.post('/p',post,{emulateJSON:true}).then(res=>{
  				this.block.error=null;
  				this.block.success=`Your picture was created successfully!`
  			},err=>{
  				console.log(err);
  				this.block.error=err.data;
  			})
  		},
  		file(e)
  		{
  			let file=e.target.files[0]||e.dataTransfer.files[0];
  			this.newpost.img=file;
  			var reader=new FileReader();
  			reader.addEventListener('load',()=>{
  				this.preview=reader.result;
  			},false)
  			reader.readAsDataURL(file);
  		}
  	}
};
</script>

<style lang="css" scoped>
</style>
