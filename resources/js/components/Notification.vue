<template>
   <div>
      <a v-on:click.prevent="showNotifications()" class="nav-link text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span v-if="numberOfNotification > 0" class="badge badge-pill badge-danger" style="float:right;margin-top: -8px; margin-left: -5px;">
      {{ numberOfNotification }}
      </span>
      <i class="fa fa-bell"></i>
      </a>    
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01" style="width: 300px; font-size: 13px; max-height: 300px; overflow-y: scroll">
         <div class="text-center" v-if="loadingEnabled">Loading</div>
         <a v-if="notifications.length > 0 && !loadingEnabled" class="btn btn-link float-md-right"  style="border-bottom:1px solid #eee; font-size: 12px;" :href="url_mark_all_as_read">Mark all as read</a>           
         <a v-if="!loadingEnabled" v-for="notification in notifications" class="dropdown-item"  style="white-space: normal !important; padding-top: 10px; padding-bottom: 10px; border-bottom:1px solid #eee;" :href="notification.url">{{ notification.message }}
         <small class="form-text text-muted">{{ notification.moment }}</small>
         </a>
         <div v-if="notifications.length == 0 && !loadingEnabled" class="text-center">No unread notification</div>
         <a v-if="!loadingEnabled" class="dropdown-item btn btn-light text-center"  style="white-space: normal !important; padding-top: 10px; padding-bottom: 10px; border-bottom:1px solid #eee;" :href="url_notification_list_page">View all notifications</a>
      </div>
   </div>
</template>

<script>


  export default {

    props: {
      url_push_notification: {
        type: String,
        default () {
          return null
        }
      },
      url_get_notifications: {
        type: String,
        default () {
          return null
        }
      },
      url_mark_all_as_read: {
        type: String,
        default () {
          return null
        }
      },
      url_notification_list_page: {
        type: String,
        default () {
          return null
        }
      }
    },
    data() {
      return {
        notifications: [],
        loadingEnabled: false,
        numberOfNotification: 0,
      }

    },

    mounted() {
      this.checkPushNotification();
      setInterval(this.checkPushNotification, 10000);

    },
    methods: {

      checkPushNotification() {
        var $scope = this;
        axios.get(this.url_push_notification).then(function (response) {

            $scope.numberOfNotification = response.data;

          })
          .catch(function (error) {});

      },

      showNotifications: function () {

        this.numberOfNotification = 0;
        var $scope = this;
        axios.get(this.url_get_notifications).then(function (response) {

            $scope.notifications = response.data;

          })
          .catch(function (error) {});

      }
    }
  } 
  </script>