<template>
    <div id="app">
        <div class="tile is-ancestor">
            <div class="tile is-vertical">
                <div class="tile">
                    <div class="tile is parent is-vertical">
                        <article class="tile is-child notification is-primary">
                            <p class="title">Password Hasher</p>
                            <p class="subtitle">Generate a password hash entirely in your browser</p>
                        </article>
                    </div>
                    <div class="tile is-parent">
                        <article class="tile is-child notification">
                            <p class="title">Enter your password</p>
                            <div class="form-group">
                                <b-field label="Password">
                                    <b-input name="password1" type="password" v-model="password1" id="password1"
                                             password-reveal></b-input>
                                </b-field>
                                <b-field label="Repeat Password">
                                    <b-input name="password2" type="password" v-model="password2" id="password2"
                                             password-reveal v-validate="'required|confirmed:password1'"
                                             data-vv-as="password"></b-input>
                                </b-field>
                                <div class="" v-show="errors.any()">
                                    <div v-if="errors.has('password2')">
                                        {{ errors.first('password2') }}
                                    </div>
                                </div>

                            </div>
                        </article>
                    </div>
                </div>
                <div class="title is-parent">
                    <article class="title is-child notification">
                        <p class="title">Unix Password Hash</p>
                        <div class="content">
                            {{ hashedPassword }}
                        </div>
                    </article>
                    <article class="title is-child notification">
                        <p class="title">MySQL Password Hash</p>
                        <div class="content">
                            {{ mysqlPassword }}
                        </div>
                    </article>
                    <article class="tile is-child notification is-warning">
                        <b-field label="Salt">
                            <b-input type="text"
                                     v-model="salt" id="salt"
                                     v-validate="'required|min:16|max:16'"
                                     data-vv-as="salt"
                                     name="salt">
                            </b-input>
                        </b-field>
                        <div class="" v-show="errors.any()">
                            <div v-if="errors.has('salt')">
                                {{ errors.first('salt') }}
                            </div>
                        </div>
                        <a class="button is-primary is-inverted" v-on:click="salt = generateSalt(16)" >Regenerate Salt</a>
                        <p class="content">Note: Entering a manual salt is not recommended!
                            This salt has been randomly generated for you. It's unlikely you'll come up with a better 16 character string.</p>
                    </article>
                </div>
            </div>
            <div class="tile is-parent is-2">
                <article class="tile is-child notification is-info">
                    <p class="title">What this is all about</p>
                    <div class="content">
                        What we're doing here is:
                        <ol>
                            <li>Take your secret password and combine it with the salt.</li>
                            <li>Convert that into a long number</li>
                            <li>Perform a specific set of mathematical functions on it.</li>
                            <li>Turn the resulting number back into a string and display it.</li>
                        </ol>
                        <div class="content">
                        <p>We do this because this is how modern password systems work.  They never store your
                            actual password, they store the mathematical hash.</p>

                        <p>One use in particular for this page is to request a password hash from someone for deployment
                        via puppet or ansible.  That way the password remains a secret, yet can be deployed to a large
                            number of servers.</p>

                        <p>Note: When using this page, the password NEVER leaves your computer, all calculations
                            are done in the browser in javascript.</p>
                        </div>
                    </div>
                </article>
            </div>
        </div> <!-- end of tile -->
    </div>
</template>

<script>

    import CryptoJS from "crypto-js"
    import sha512crypt from "sha512crypt-node"

    // short cuts
    let sha1 = CryptoJS.SHA1;
    let crypt = sha512crypt.sha512crypt;
    let enc = CryptoJS.enc;


  export default {
    name: 'app',
    data () {
      return {
        salt: this.generateSalt(16),
        password1: "",
        password2: "",
      }
    },
    methods: {
      allFieldsReady() {

        return this.password1 === this.password2 && this.password1 !== ""  && this.salt.length === 16;
      },
      generateSalt(len) {

        let valid = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ" +
          "abcdefghijklmnopqrstuvwxyz./-+_";

        let salt = "";
        for (let i = 0; i < len; ++i) {
          salt += valid.charAt(Math.floor(Math.random() * valid.length));
        }

        return salt
      }
    },
    computed: {
        matchPassword: function () {

          return this.password1 === this.password2
        },
        hashedPassword: function () {

          if (this.allFieldsReady()) {
            return crypt(this.password1, this.salt)
          }
          return ""
        },
        mysqlPassword: function () {

          if (this.allFieldsReady()) {
            return sha1(sha1(this.password1)).toString(enc.Hex).toUpperCase()
          }
          return ""
        }
    }
  }
</script>

<style>

#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
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
