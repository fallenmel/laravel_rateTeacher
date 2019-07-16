<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                  <div class="card-header">Teacher</div>
                  <div class="container" >
                    <div class="row" id="teacher-section">
                      <div id="teacher-wrapper" class="col-sm-4" v-for="teacher in dataTeachers">
                        <h2>{{teacher.teacher_name}}</h2>
                        <h3>{{teacher.teacher_email}}</h3>
                        <button v-if="teacher.rate" class="btn btn-success" @click="updateTeacher(teacher)" >Update</button>
                        <button v-else class="btn btn-success" @click="rateTeacher(teacher)" >Rate</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>

      <div class="modal fade" id="rateTeacherModal" 
        tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" 
                data-dismiss="modal" 
                aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
             <form @submit="addRating">
                <div class="form-group">
                  <label>Rate your teacher</label>
                  <star-rating @rating-selected ="setRating" :rating="rating"></star-rating >
                </div>
                <div class="form-group">
                  <label>Which language did you learn</label>
                  <select v-model="language" class="form-control" >
                    <option :value="null" selected disabled>Choose</option>
                    <option value="english">English</option>
                    <option value="mandarin">Mandarin</option>
                    <option value="nihongo">Nihongo</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>How many lesson did you take</label>
                  <input type="number" class="form-control" v-model="lessonCount"></textarea>
                </div>
                <div class="form-group">
                  <label>Please write your review</label>
                  <textarea class="form-control" v-model="notes"></textarea>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
                <div v-if="formErr" class="alert alert-danger">
                  Please Answer all fields
                </div>
             </form>
            </div>
          </div>
        </div>
      </div>
    </div>


</template>

<script>


    export default {
      props: ['teachers'],
      mounted() {
          console.log('Component mounted.')
          console.log(this.teachers)
          this.dataTeachers = this.teachers;
      },
      data(){
        return ({
          dataTeachers : '',
          currentId : '',
          rating : 0,
          notes: '',
          language: null,
          lessonCount: '',
          action: '',
          ratingID:'',
          formErr:'',
        })
      },
      methods:{
        rateTeacher: function(teacher){
          this.currentId = teacher.teacher_id;
          //reset
          this.rating = 0;
          this.notes = '';
          this.language = null;
          this.lessonCount = ''
          this.action = 'addRate'; 
          this.formErr = '',
          $('#rateTeacherModal').modal('show');
        },

        updateTeacher: function(teacher){
          console.log('teacher', teacher);
          this.currentId = teacher.teacher_id;
          this.rating = teacher.rate;
          this.notes = teacher.notes;
          this.language = teacher.language;
          this.lessonCount = teacher.num_lession;
          this.action = 'updateRate';
          this.ratingID = teacher.rating_id;
          this.formErr = '',
          $('#rateTeacherModal').modal('show');
        },

        addRating(e){
          e.preventDefault(); 
          console.log('pass send form');
          console.log('call api here');

          const formData = {
            teacherId : this.currentId,
            rating : this.rating,
            note: this.notes,
            language: this.language,
            lessonCount: this.lessonCount,
          }

          if( !formData.rating || !formData.note || !formData.language || !formData.lessonCount ){
            this.formErr = true;
          }else{
            const _this = this;
            if( this.action == 'addRate'){
              axios.post('/formSubmit', formData)
              .then(function (response) {
                const resData = response.data[0];
                console.log('resData', resData);
                
                const objIndex = _this.dataTeachers.findIndex(obj => obj.teacher_id === resData.teacher_id);
              
                _this.dataTeachers[objIndex].language = resData.language;
                _this.dataTeachers[objIndex].notes = resData.notes;
                _this.dataTeachers[objIndex].num_lession = resData.num_lession;
                _this.dataTeachers[objIndex].rate = resData.rate;
                _this.dataTeachers[objIndex].rating_id = resData.rating_id;
              
                console.log('_this.dataTeachers', _this.dataTeachers);
                $('#rateTeacherModal').modal('toggle');
              })
              .catch(function (error) {
                  console.log(error);
              });
            }

            if( this.action == 'updateRate'){
              formData.ratingID = this.ratingID; //append rating ID
              axios.post('/formSubmitUpdate', formData)
              .then(function (response) {
                const resData = response.data[0];
                
                const objIndex = _this.dataTeachers.findIndex(obj => obj.teacher_id === resData.teacher_id);             
                _this.dataTeachers[objIndex].language = resData.language;
                _this.dataTeachers[objIndex].notes = resData.notes;
                _this.dataTeachers[objIndex].num_lession = resData.num_lession;
                _this.dataTeachers[objIndex].rate = resData.rate;
                console.log('_this.dataTeachers', _this.dataTeachers);
                $('#rateTeacherModal').modal('toggle');
              })
              .catch(function (error) {
                  console.log(error);
              });
            }
          }
        },

        setRating(rating){
          this.rating = rating;
        }
      }
    }
</script>
