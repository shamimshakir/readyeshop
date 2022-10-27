<template>
  <div class="wrapper-page">
    <div class="card">
      <div class="card-body">
        <h3 class="text-center m-0">
          <a href="#" class="logo logo-admin"
            ><img
              src="https://readyeshop.com/images/logo.png"
              height="30"
              alt="logo"
          /></a>
        </h3>
        <div class="p-3">
          <h4 class="text-muted font-18 m-b-5 text-center">Welcome Back !</h4>
          <p class="text-muted text-center">
            Sign in to continue to Ready Shop
          </p>
          <form class="form-horizontal m-t-30" @submit.prevent="checkLogin">
            <div class="form-group">
              <label for="email">Email Address</label> 
              <input type="text" v-model="logInput.email" name="email" placeholder="Email Address" :class="checkError('email')
                  ? 'form-control border-danger'
                  : 'form-control' " />
              <p class="text-danger"  v-if="checkError('email')" v-for="email in errors.email">
                  {{ email }}
              </p>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" 
                :class="checkError('password')
                    ? 'form-control border-danger'
                    : 'form-control' " 
                    v-model="logInput.password" 
                    placeholder="Password" />
                <p class="text-danger"  v-if="checkError('password')"  v-for="password in errors.password">
                    {{ password }}
                </p>
            </div>
            <div class="form-group row m-t-20">
              <div class="col-6"></div>
              <div class="col-6 text-right">
                <button
                  class="btn btn-primary w-md waves-effect waves-light"
                  type="submit"
                >
                  Log In
                </button>
              </div>
            </div>
            <div class="form-group m-t-10 mb-0 row">
              <div class="col-12 m-t-20">
                <a class="text-muted"
                  ><i class="mdi mdi-lock"></i> Forgot your password?</a
                >
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      logInput: {
        email: "",
        password: "",       
      },
      errors: {},
    };
  },
  created() {
    this.checkSessionToken();
  },
  methods: {
    checkError(field){
        if(!this.isEmpty(this.errors)){
            if(field in this.errors){
                return true
            }
        }
        return false;
    },
    isEmpty(obj) {
        return Object.keys(obj).length === 0;
    },
    checkSessionToken() {
      let sessionData = JSON.parse(sessionStorage.getItem("loginInfo"));
      if (sessionData) {
        this.$router.push("/").catch(() => {});
      } else {
        this.$router.push("/login").catch(() => {});
      }
    },
    checkLogin() {
      this.$root.getFrontData(this.logInput, '/api/user/login').then(response => {
          //console.log(response);
          this.$fire({
                  title: response.data.message,
                  type: "success",
                  timer: 2000
              });
          let sessionObj = {
            email: response.data.users.email,
            full_name: response.data.users.full_name,
            token: response.data.token,
          };
          sessionStorage.setItem("loginInfo", JSON.stringify(sessionObj));
          this.$store.commit("UPDATE_TOKEN_FROM_LOGIN", response.data.token);
          // this.$router.push("/").catch(() => {});
          location.reload();
          event.target.reset();
          this.$router.push({
              name: "customers"
          });
      }).catch(error => {
          let res = JSON.parse(error.request.response);
          //console.dir(res);
          if (res.status == "error") {
              this.errors = JSON.parse(error.request.response).validation_errors;
             // console.dir(this.errors)
          }

          if (res.status == "failed") {
              this.$fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: res.message,
                  type: "error",
                  timer: 2000
              });
          }

      })
        
    },
  },
};
</script>
