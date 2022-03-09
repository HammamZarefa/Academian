<template>
   <div>
      <form method="POST" :action="submit_work_url">
         <div class="card">
            <div class="card-header">
               Submit your work
            </div>              
            <div class="card-body">
               <div class="form-group">
                  <label>Attachment (.zip,.rar,.7zip only)</label>
                  <VueFileAgent
                     ref="vueFileAgent"
                     :theme="'list'"
                     :multiple="true"
                     :deletable="true"
                     :meta="true"
                     :accept="'.zip,.rar,.7zip'"
                     :maxSize="'10MB'"
                     :maxFiles="1"
                     :helpText="'Choose your files '"
                     :errorText="{
                     type: 'Invalid file type. Only images, .pdf, .doc Allowed',
                     size: 'Files should not exceed 10MB in size',
                     }"
                     @select="filesSelected($event)"
                     @delete="fileDeleted($event)"
                     @upload="onUpload($event)"
                     v-model="form.files_data"
                     ></VueFileAgent>
               </div>

               <div class="form-group">
                  <label>Your Message <span class="required">*</span></label>
                  <textarea class="form-control" name="message" v-model="form.message"></textarea>
               </div>
               <input type="hidden" name="name" v-model="form.name">
               <input type="hidden" name="display_name" v-model="form.display_name">
               <input type="hidden" name="_token" :value="csrf">             
               <button v-if="form.files_data.length > 0" class="btn btn-success btn-lg btn-block" type="submit">
                <i class="far fa-paper-plane"></i> Submit
              </button>
            </div>
         </div>
      </form>
   </div>
</template>
<script>
   export default {
    
    props: {
     
      upload_attachment_url: {          
         type: String,
         default() {
            return null
        }          
      },
      submit_work_url: {          
         type: String,
         default() {
            return null
        }          
      }
      
   },  
   
    data () {
      return {        
        form : {
          message : "",  
          name : "",
          display_name : "",       
          files_data: [], 
        },
        csrf: document.querySelector('meta[name="csrf-token"]').content ,
        uploadUrl: this.upload_attachment_url,
        uploadHeaders: { 
          'X-Test-Header': 'vue-file-agent', 
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content 
        },
        filesDataForUpload: []
        
   
        
       
      }
    },    
    methods: {
      
     uploadFiles: function() {      
      
        // Using the default uploader. You may use another uploader instead.
        this.$refs.vueFileAgent.upload(this.uploadUrl, this.uploadHeaders, this.filesDataForUpload);
        this.filesDataForUpload = [];
      },
      deleteUploadedFile: function(fileData) {
        // Using the default uploader. You may use another uploader instead.
        this.$refs.vueFileAgent.deleteUpload(this.uploadUrl, this.uploadHeaders, fileData);
      },
      filesSelected: function(filesDataNewlySelected) {
   
        var validFilesData = filesDataNewlySelected.filter((fileData) => !fileData.error);
        this.filesDataForUpload = this.filesDataForUpload.concat(validFilesData);
        this.uploadFiles();
      },
      fileDeleted: function(fileData) {
        var i = this.filesDataForUpload.indexOf(fileData);
        if (i !== -1) {
          this.filesDataForUpload.splice(i, 1);
        } else {
          this.deleteUploadedFile(fileData);
        }
      },
      onUpload(){

        var $scope = this;

        this.$nextTick(() => {
          if(this.form.files_data.length > 0)
            {
     
              var row = this.form.files_data[0].upload.data;
              this.setAttachment(row.name, row.display_name);  
            }    
        });
        
      },
      setAttachment(name, display_name){
        this.form.name          = name;
        this.form.display_name  = display_name;        
      } 
     
   
   }
}
</script>
