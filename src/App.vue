<template>
    <div id="app">
        <div class="container">
            <p>
                Submit the password you'd like to hash. You can optionally add a salt value, but we've already generated one for
                you.</p>
            <div class="form-group">
                <label for="password1">Passwords</label>
                <input type="password" v-model="password1" placeholder="Password" id="password1">
                <input type="password" v-model="password2" placeholder="Repeat Password" id="password2">
            </div>
            <div class="form-group">
                <label for="salt">Salt</label>
                <input type="text" v-model="salt" id="salt">
            </div>
            <p class="alert-warning">Note: Entering a manual salt is not recommended!</p>
        </div>

        <div class="container">
            <p>The resulting hash (including the salt) is: <br><br>{{ hashedPassword }}<br><br>
                Please email this to the person
                that requested the hash.</p>
        </div>
        <div class="container">
            <p> Bonus: Here is the mysql compatible hash of the same password: {{ mysqlPassword }}</p>
        </div>
    </div>
</template>

<script>

    import CryptoJS from "crypto-js"
    import sha512crypt from "sha512crypt-node"

    let sha1 = CryptoJS.SHA1();
    let enc = CryptoJS.enc();

  function generateSalt(len) {
    let valid = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ" +
      "abcdefghijklmnopqrstuvwxyz./-+_";

    let salt = "";
    for (let i = 0; i < len; ++i) {
      salt += valid.charAt(Math.floor(Math.random() * valid.length));
    }

    return salt

  }

  export default {
    name: 'app',
    data () {
      return {
        salt: generateSalt(16),
        password1: "",
        password2: "",
      }
    },
    computed: {
        hashedPassword: function () {
          if ((this.password1 !== this.password2) || this.password1 === "") {
            return ""
          } else {
            return sha512crypt(this.password1, this.salt)
          }
        },
        mysqlPassword: function () {
          if ((this.password1 !== this.password2) || this.password1 === "") {
            return ""
          } else {
            return sha1(sha1(this.password1)).toString(enc.Hex).toUpperCase()
          }
        }
    }
  }
</script>

<style>

#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
h1, h2 {
    font-weight: normal;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    display: inline-block;
    margin: 0 10px;
}

a {
    color: #42b983;
}
</style>
