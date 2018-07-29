import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';


@Injectable({
  providedIn: 'root'
})
export class DataService {
  private api: string = 'http://localhost:8000/api';

  constructor(private http: HttpClient) { }
  getCategories() {

    return this.http.get(this.api + '/category');
  }
  getProverb(params:string){

    return this.http.get(this.api +'/proverb' + params)
  }
}
