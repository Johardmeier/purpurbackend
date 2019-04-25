<template>
  <!--UPLOAD-->
  <form enctype="multipart/form-data" novalidate>
    <div class="modal-card" style="width: 800px">
      <header class="modal-card-head">
        <p class="modal-card-title">Image input</p>
      </header>
      <section class="modal-card-body">
        <div class="dropzone">
          <input
            type="file"
            multiple
            :name="uploadFieldName"
            :disabled="!isReady"
            @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length"
            accept="image/*"
            class="input-file"
          />
          <p v-if="isReady">
            Drag your file(s) here to begin<br> or click to browse
          </p>
          <p v-else> working... </p>
        </div>
        <div :key="refresh">
          <div class="card xyz-box-class" v-for="fileObj in filesToUpload" :key="fileObj.index">
            <div class="card-image">
              <figure class="image is-4by3">
                <i class="fas fa-spinner fa-pulse" v-if="fileObj.src === ''"></i>
                <img :src="fileObj.src" alt="" v-else />
              </figure>
            </div>
            <p class="is-size-7">
              <span class="icon has-text-warning" v-if="fileObj.alt === ''">
                <i class="fas fa-comment-dots"></i>
              </span>
              <span v-if="fileObj.alt === ''">0</span>
              <span class="icon has-text-success" v-if="fileObj.alt === ''">
                <i class="fas fa-comment-alt"></i>
              </span>
              <span v-if="fileObj.alt === ''">0</span>
            </p>
          </div>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button class="button" type="button" @click="saveModel">Speichern</button>
        <button class="button" type="button" @click="closeEdit">Abbrechen</button>
      </footer>
    </div>
  </form>
</template>

<script>
export default {
  name: "imageInput",
  data: function() {
    return {
      filesToUpload: [],
      isReady: true,
      isSaving: false,
      uploadFieldName: "testUploader",
      refresh: 1
    };
},
  computed: {
    cropperDivStyle: function() {
      return null;
    }
  },
  methods: {
    filesChange(fieldName, files) {
      let imageType = /^image\//;
      for (let i = 0; i < files.length; i++) {
        let file=files[i];
        if (!imageType.test(file.type)) continue;
        let res = { src: "", alt: "", name: file.name , size: file.size, type: file.type, crop:{}};
        this.filesToUpload.push(res);
        let reader = new FileReader();
        reader.onload = function(e) { res.src = e.target.result; this.refresh++ };
        reader.readAsDataURL(files[i]);
      }
    },
    saveModel: function(){

    },
    closeEdit: function(){

    },
    reset() {
      // reset form to initial state
      this.isReady=true;
      this.filesToUpload = [];
    },
    selectFile: function (evt) {
    },
    moveMouse: function (event) {
    },
  }
};
</script>

<style lang="scss">
.xyz-box-class {
  margin: 4px;
  padding: 4px;
  border-radius: 8px;
  width: 128px;
  display: inline-block;
  img {
    border-radius: 6px;
  }
}

.dropzone {
  outline: 2px dashed gray; /* the dash box */
  outline-offset: -10px;
  background: lightcyan;
  color: dimgray;
  padding: 8px 8px;
  position: relative;
  cursor: pointer;
}

.input-file {
  opacity: 0; /* invisible but it's there! */
  width: 95%;
  height: 95%;
  position: absolute;
  cursor: pointer;
}

.dropzone:hover {
  background: lightblue; /* when mouse over to the drop zone, change color */
}

.dropzone p {
  font-size: 1.2em;
  text-align: center;
  padding: 35px 15px;
}
</style>

<!--
        <div
          v-if="cropping"
          ref="cropperdiv"
          :style="cropperDivStyle"
        >
          <canvas
            ref="canvas"
            :width="canvasWidth"
            :height="canvasHeight"
            @mousemove="moveMouse"
            @mousedown="startDrag"
            @mouseup="stopDrag"
            @dragover="stopDrag">
          </canvas>
        </div>
        <img v-bind:src="croppedImage" :style="roundCorners" alt="resultImage" />

            cropperDivStyle: function () {
      return {width: this.cropperDivWidth, height: this.cropperHeight+'px', textAlign: 'center'};
    },
    cropperHeight: function () {
      return this.cropperDivHeight ? this.cropperDivHeight : this.cropperDivMaxHeight;
    },
    cropperWidth: function () {
      return  this.cropping && this.$refs.cropperdiv.offsetWidth;
    },
    cropperDivRatio: function () {
      return this.cropperWidth/this.cropperHeight;
    },
    imageRatio: function () {
      return this.imageWidth/this.imageHeight;
    },
    markers: function () {
      return {
        nw: {x: this.x - this.markerSize/2, y: this.y - this.markerSize/2},
        ne: {x: this.x + this.w - this.markerSize/2, y: this.y - this.markerSize/2},
        sw: {x: this.x - this.markerSize/2, y: this.y + this.h - this.markerSize/2},
        se: {x: this.x + this.w - this.markerSize/2, y: this.y + this.h - this.markerSize/2}
      };
    },
    cw: function () {
      return this.croppedWidth || this.w;
    },
    ch: function () {
      return this.croppedHeight || this.h;
    },
    roundCorners: function () {
      if (this.circle) {
        return {borderRadius: '100%'};
      } else return false;
    }
  },
  methods: {
    selectFile: function (evt) {
      var file = evt.currentTarget.files[0];
      var reader = new FileReader();
      var cropper = this;
      reader.onload = function (evt) {
        cropper.cropping = true;
        if (cropper.circle) {cropper.aspectRatio = 1; cropper.h = cropper.w;}
        var image = new Image();
        image.src = evt.target.result;
        image.onload = function() {
          cropper.image = image;
          cropper.drawing = true;
          cropper.imageWidth = image.width;
          cropper.imageHeight = image.height;
          cropper.canvasWidth = cropper.cropperWidth;
          cropper.canvasHeight = cropper.cropperHeight;
          if (cropper.imageRatio < cropper.cropperDivRatio) {
            cropper.canvasWidth = cropper.canvasHeight * cropper.imageRatio;
          }
          if (cropper.imageRatio > cropper.cropperDivRatio) {
            cropper.canvasHeight = cropper.canvasWidth / cropper.imageRatio;
          }

          Vue.nextTick(function () {
            var canvas = cropper.$refs.canvas;
            cropper.ctx  = canvas.getContext('2d');
            cropper.ctx.drawImage(cropper.image, 0, 0, cropper.canvasWidth, cropper.canvasHeight);
          });

        };
      };
      reader.readAsDataURL(file);
    },
    moveMouse: function (event) {
      if (event === undefined) return false;
      var doc = document.documentElement;
      var scrollLeft = (window.pageXOffset || doc.scrollLeft) - (doc.clientLeft || 0);
      var scrollTop = (window.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0);
      var x = event.clientX - event.target.offsetLeft + scrollLeft;
      var y = event.clientY - event.target.offsetTop + scrollTop;
      var ctx = this.ctx;

      //draw the image
      ctx.clearRect(0, 0, this.canvasWidth, this.canvasHeight);
      ctx.drawImage(this.image, 0, 0, this.canvasWidth, this.canvasHeight);

      //update coords
      if (this.dragged) this.updateCoords(x,y);

      //draw crop area and handles
      this.drawSelection(ctx,x,y);

      //crop image
      var scaleX = this.imageWidth / this.canvasWidth;
      var scaleY = this.imageHeight / this.canvasHeight;
      resultCanvas = document.createElement('canvas');
      resultCanvas.width = this.cw;
      resultCanvas.height = this.ch;
      resultCanvas.getContext('2d').drawImage(this.image, this.x * scaleX, this.y * scaleY, this.w * scaleX, this.h * scaleY, 0, 0, this.cw, this.ch);
      this.croppedImage = resultCanvas.toDataURL();

    },
    drawSelection: function (ctx,x,y) {
      this.drawOverlay(ctx);
      this.$refs.canvas.style.cursor = 'default';

      ctx.beginPath();
      if (!this.circle) {ctx.rect(this.x, this.y, this.w, this.h);}
      else {
        ctx.arc(this.x + this.w / 2, this.y + this.h / 2, this.w / 2, 0, 2 * Math.PI);
      }
      if (ctx.isPointInPath(x, y)) {
        this.$refs.canvas.style.cursor = 'move';
      }
      ctx.setLineDash(this.lineDash);
      ctx.strokeStyle = this.mainStroke;
      ctx.stroke();
      ctx.setLineDash([]);

      for (var p in this.markers) {
        var rectangle = this.markers[p];
        ctx.beginPath();
        ctx.rect(rectangle.x, rectangle.y, this.markerSize, this.markerSize);
        ctx.fillStyle = this.fillStyle;
        ctx.strokeStyle = this.strokeStyle;
        if (ctx.isPointInPath(x, y)) {
          ctx.fillStyle = this.hoverFillStyle;
          ctx.strokeStyle = this.hoverStrokeStyle;
          this.$refs.canvas.style.cursor = p+'-resize';
        }
        ctx.fill();
        ctx.stroke();

      }
    },
    drawOverlay: function (ctx) {
      ctx.fillStyle = this.overlayStyle;
      ctx.fillRect(0,0,this.canvasWidth, this.y);
      ctx.fillRect(0,this.y, this.x, this.h);
      ctx.fillRect(this.x+this.w, this.y, this.canvasWidth - (this.x+this.w), this.h);
      ctx.fillRect(0, this.y+this.h, this.canvasWidth, this.canvasHeight - (this.y+this.h));
      if (this.circle) {
        ctx.beginPath();
        ctx.arc(this.x + this.w / 2, this.y + this.h / 2, this.w / 2, Math.PI, 1.5 * Math.PI);
        ctx.lineTo(this.x, this.y);
        ctx.closePath();
        ctx.fill();
        ctx.beginPath();
        ctx.arc(this.x + this.w / 2, this.y + this.h / 2, this.w / 2, 1.5 * Math.PI, 2 * Math.PI);
        ctx.lineTo(this.x + this.w, this.y);
        ctx.closePath();
        ctx.fill();
        ctx.beginPath();
        ctx.arc(this.x + this.w / 2, this.y + this.h / 2, this.w / 2, 0, 0.5 * Math.PI);
        ctx.lineTo(this.x + this.w, this.y + this.h);
        ctx.closePath();
        ctx.fill();
        ctx.beginPath();
        ctx.arc(this.x + this.w / 2, this.y + this.h / 2, this.w / 2, 0.5 * Math.PI, Math.PI);
        ctx.lineTo(this.x, this.y + this.h);
        ctx.closePath();
        ctx.fill();
      }
    },
    startDrag: function (event) {
      var doc = document.documentElement;
      var scrollLeft = (window.pageXOffset || doc.scrollLeft) - (doc.clientLeft || 0);
      var scrollTop = (window.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0);
      var x = event.clientX - event.target.offsetLeft + scrollLeft;
      var y = event.clientY - event.target.offsetTop + scrollTop;
      var ctx = this.ctx;

      for (var p in this.markers) {
        var rectangle = this.markers[p];
        ctx.beginPath();
        ctx.rect(rectangle.x, rectangle.y, this.markerSize, this.markerSize);
        if (ctx.isPointInPath(x, y)) {
          this.dragged = p;
          this.deltaX = x - rectangle.x;
          this.deltaY = y - rectangle.y;
          return;}
      }
      ctx.beginPath();
      if (!this.circle) {ctx.rect(this.x, this.y, this.w, this.h);}
      else {
        ctx.arc(this.x + this.w / 2, this.y + this.h / 2, this.w / 2, 0, 2 * Math.PI);
      }
      if (ctx.isPointInPath(x, y)) {
        this.dragged = 'all';
        this.deltaX = x - this.x;
        this.deltaY = y - this.y;
        return;}
    },
    stopDrag: function () {
      this.dragged = false;
      this.deltaX = 0;
      this.deltaY = 0;
    },
    updateCoords: function (x,y) {
      var newX, newY, newW, newH;
      if (this.dragged == 'all') {
        newX = x - this.deltaX;
        newY = y - this.deltaY;
        newW = this.w;
        newH = this.h;
      }
      else {
        var ox = this.dragged[1] == 'w' ? 'e' : 'w';
        var oy = this.dragged[0] == 'n' ? 's' : 'n';
        var oppositeIdx = oy+ox;
        if (ox == 'e') {
          newX = x - this.deltaX + this.markerSize / 2;
          newW = this.markers[oppositeIdx].x - newX  + this.markerSize / 2;
        }
        else {
          newX = this.x;
          newW = x - this.deltaX - this.markers[oppositeIdx].x;
        }
        if (oy == 's') {
          newY = y - this.deltaY + this.markerSize / 2;
          newH = this.markers[oppositeIdx].y - newY + this.markerSize / 2;
        }
        else {
          newY = this.y;
          newH = y - this.deltaY - this.markers[oppositeIdx].y;
        }
      }

      if (this.aspectRatio) {newH = newW / this.aspectRatio;}

      if (newX < 0) newX = 0;
      if (newY < 0) newY = 0;
      if (newX + newW > this.canvasWidth) {
        newW = this.canvasWidth - newX;
        if (this.aspectRatio) {newH = newW / this.aspectRatio;}
      }
      if (newY + newH > this.canvasHeight) {
        newH = this.canvasHeight - newY;
        if (this.aspectRatio) {newW = newH * this.aspectRatio;}
      }
      if (newW < this.minWidth) {newW = this.minWidth; newH = newW / this.aspectRatio;}
      if (newH < this.minHeight) {newH = this.minHeight; newW = newH * this.aspectRatio;}

      this.x = newX;
      this.y = newY;
      this.w = newW;
      this.h = newH;


    }
  }

-->