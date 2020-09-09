const captcha = {
  data () {
    return {
      cf_captcha : null,
      cf_captcha_text : null,
      captcha_modify : false,
    }
  },
  methods: {
    captcha(){
      if(this.cf_captcha == 'kcaptcha' && this.$store.state.isLogin == false || this.captcha_modify == true) {
        console.log(this.cf_captcha_text);
        var canvas = document.createElement("canvas");
        var input = document.createElement("input");
        var refresh = document.createElement("button");
        refresh.innerHTML = '<i class="fas fa-sync-alt"></i>';
        var style = "height:50px;"
        var classStyle = "px-3";
        refresh.style=style;
        refresh.className=classStyle;
        refresh.type="button";
        var sound = document.createElement("button");
        sound.style=style;
        sound.className=classStyle;
        sound.type="button";
        sound.innerHTML = '<i class="fas fa-volume-up"></i>';
        input.className = "border py-1 px-2 dark:bg-gray-500";
        input.style.width = "100px";
        input.name="captcha_key";
        input.id="captcha_key";
        let self = this;
        sound.addEventListener('click', function() {
          var synth = window.speechSynthesis;
          var utterThis = new SpeechSynthesisUtterance(this.cf_captcha_text);
          utterThis.lang = "ko-KR";
          utterThis.text = self.cf_captcha_text;
          synth.speak(utterThis);
        }, false);
        refresh.addEventListener('click', function() {
          window.req_api({
            captcha : true,
          }).then(function(json){
            self.cf_captcha_text = json.captcha;
            self.captcha();
          });
        }, false);
        canvas.id = "Kcaptcha";
        canvas.width = 100;
        canvas.height = 50;
        canvas.style.background= "#fff";
        var ctx = canvas.getContext("2d");
        ctx.font = "25px Georgia";
        ctx.strokeText(this.cf_captcha_text, 5 , 30);
        for(var i=0;i<20;i++){
          ctx.strokeStyle ="#" +  Math.floor(Math.random()*0xFFFFFF).toString(16);
          ctx.beginPath();
          ctx.arc(Math.floor(Math.random()*(100)+1) , Math.floor(Math.random()*(80)+1), Math.floor(Math.random()*(100)+1), 0 ,2*Math.PI);
          ctx.stroke();
        }
        const num = 20;
        const radius = 2;
        const max = 100;
        for (i = 0; i <=num; i++) {
          ctx.strokeStyle ="#" +  Math.floor(Math.random()*0xFFFFFF).toString(16);
          ctx.beginPath();
          var rand_x = Math.random(i) * max;
          var rand_y = Math.random(i) * max;
          ctx.arc(rand_x, rand_y, radius, 0, 2*Math.PI);
          ctx.fill();
          ctx.closePath();
        }
        this.$nextTick(() => {
          this.$refs.captcha.innerHTML = '';
          this.$refs.captcha.appendChild(canvas);
          this.$refs.captcha.appendChild(refresh);  
          this.$refs.captcha.appendChild(sound);  
          this.$refs.captcha.appendChild(input);  
        });
      }
    },
  },
};
export default captcha;
