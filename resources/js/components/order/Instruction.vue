<template>
  <div>
    <h5 class="card-title">
     {{ $t('step') }}
      <b>2 </b>{{ $t('Of') }}
      <span class="small">3</span>
    </h5>
    <h6>{{ $t('ADDITIONAL PAPER DETAILS') }} </h6>
    <div class="form-group">
      <label>Title <span class="required">*</span></label>
      <input type="text" class="form-control" v-model="form.title" style="height: 55px;" />
      <div class="invalid-feedback d-block" v-if="errors.title">{{ errors.title[0] }}</div>
    </div>
    <div class="form-group">
      <label>{{ $t('Specific Instructions') }}  <span class="required">*</span></label>
      <textarea
        class="form-control"
        v-model="form.instruction"
        placeholder="E.g., preferred paper structure, outline, grading scale, or any particular work focus."
      ></textarea>
      <div class="invalid-feedback d-block" v-if="errors.instruction">{{ errors.instruction[0] }}</div>
    </div>
    <!--Upload files -->
    <VueFileAgent
      ref="vueFileAgent"
      :theme="'list'"
      :multiple="true"
      :deletable="true"
      :meta="true"
      :accept="'.xlsx,.xls, .doc, .docx,.ppt, .pptx,.txt,.pdf, application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf, image/*'"
      :maxSize="'10MB'"
      :maxFiles="2"
      
      :errorText="{
                     type: 'Invalid file type. Only images, .pdf,.doc,.ppt,.txt files are allowed',
                     size: 'Files should not exceed 10MB in size',
                     }"
      @select="filesSelected($event)"
      @delete="fileDeleted($event)"
      v-model="form.files_data"
    ></VueFileAgent>
    <!--  <button :disabled="!filesDataForUpload.length" @click="uploadFiles($event)">
                     Upload {{ filesDataForUpload.length }} files
    </button>-->
    <!-- <a href="#" v-on:click.prevent="changeTab(1)">{{ $t('Previous') }}</a> -->
    <br />
    <div class="custom-control custom-checkbox">
      <input  :value="1" type="checkbox" class="custom-control-input" id="termsCheckBox" v-model="agreedToTermsChecked">
      <label class="custom-control-label" for="termsCheckBox">
       {{ $t('I agree to the') }} <a :href="term_and_condition_url" target="_blank">{{ $t('Terms and Conditions') }}</a>
        {{ $t('and') }} <a :href="privacy_policy_url" target="_blank">{{ $t('Privacy Policy') }}</a>
      </label>
    </div>
    <br>
   <div class="con-butt">
      <button v-on:click.prevent="changeTab(1)" class="btn btn-Quest btn-lg" >
      {{ $t('Previous') }} 
    </button>
    <button :disabled="!agreedToTermsChecked" class="btn btn-Create btn-lg" v-on:click.prevent="submit()">
      {{ $t('Pay now') }} 
    </button>
   </div>
  </div>
</template>

<script>
export default {
  props: {
    upload_attachment_url: {
      type: String,
      default() {
        return null;
      }
    },
    term_and_condition_url: {
      type: String,
      default() {
        return null;
      }
    },
    privacy_policy_url: {
      type: String,
      default() {
        return null;
      }
    },
    errors: {
      type: Object,
      default() {
        return null;
      }
    }
  },
  computed: {
    classObject: function() {
      return {
        "text-danger": this.error && this.error.type === "fatal"
      };
    }
  },
  data() {
    return {
      agreedToTermsChecked: false,
      form: {
        title: "",
        instruction: "",
        files_data: []
      },
      uploadUrl: this.upload_attachment_url,
      uploadHeaders: {
        "X-Test-Header": "vue-file-agent",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
          .content
      },
      filesDataForUpload: []
    };
  },

  methods: {
    changeTab(tabNumber) {
      this.$emit("changeTab", tabNumber);
    },
    submit() {
      this.$emit("submitRequest", this.form);
    },
    uploadFiles: function() {
      // Using the default uploader. You may use another uploader instead.
      this.$refs.vueFileAgent.upload(
        this.uploadUrl,
        this.uploadHeaders,
        this.filesDataForUpload
      );
      this.filesDataForUpload = [];
    },
    deleteUploadedFile: function(fileData) {
      // Using the default uploader. You may use another uploader instead.
      this.$refs.vueFileAgent.deleteUpload(
        this.uploadUrl,
        this.uploadHeaders,
        fileData
      );
    },
    filesSelected: function(filesDataNewlySelected) {
      var validFilesData = filesDataNewlySelected.filter(
        fileData => !fileData.error
      );
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
    }
  }
};
</script>
<style lang="scss" scoped>
.card-title{
    font-weight: 600;
    font-size: 18px;
    line-height: 24px;
    letter-spacing: 0.1px;
    color: #06243E;
}
.small{
    font-size: 18px;
    font-weight: 501;
}
h6{
    font-weight: 501;
    font-size: 16px;
    line-height: 22px;
    letter-spacing: 0.5px;
    color: #06243E;
}
.btn-Create{
    background-color: #3667BF;
    color: #fff;
}
.btn-Create:hover{
    background-color: #06243E;
}
.btn-Quest{
    background-color: #fff;
    color: #3667BF;
}
.btn-Quest:hover{
    background-color: #C4DEF4;
    color: #06243E;
}
.con-butt{
  display: flex;
  justify-content: space-between;
}
.con-butt button{
      width: 48%;
}
@media (max-width:768px) {
  .con-butt{
  flex-direction: column;
}
.con-butt button{
      width: 100%;
      margin: 10px 0;
}
}
</style>