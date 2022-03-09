<template>
  <div>
    <h5 class="card-title">
      Step
      <b>2</b>/
      <span class="small">3</span> ADDITIONAL PAPER DETAILS
    </h5>
    <hr />

    <div class="form-group">
      <label>Title <span class="required">*</span></label>
      <input type="text" class="form-control" v-model="form.title" />
      <div class="invalid-feedback d-block" v-if="errors.title">{{ errors.title[0] }}</div>
    </div>
    <div class="form-group">
      <label>Specific Instructions <span class="required">*</span></label>
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
      :helpText="'Choose your files'"
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
    <br />
    <a href="#" v-on:click.prevent="changeTab(1)">Previous</a>
    <br />
    <br />
    <div class="custom-control custom-checkbox">
      <input  :value="1" type="checkbox" class="custom-control-input" id="termsCheckBox" v-model="agreedToTermsChecked">
      <label class="custom-control-label" for="termsCheckBox">
        I agree to the <a :href="term_and_condition_url" target="_blank">Terms and Conditions</a>
        and <a :href="privacy_policy_url" target="_blank">Privacy Policy</a>
      </label>
    </div>
    <br>

    <button :disabled="!agreedToTermsChecked" class="btn btn-success btn-lg btn-block" v-on:click.prevent="submit()">
      <i class="far fa-check-circle"></i> Pay now
    </button>
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
