import { Component, OnInit } from '@angular/core';
import { DataService } from '../data.service';

export interface Category {
  id: number;
  label: string;
}

export interface Proverb {
  id: number;
  title: string;
  auteur:string;
  category:Category;  
}
@Component({
  selector: 'app-proverb',
  templateUrl: './proverb.component.html',
  styleUrls: ['./proverb.component.css']
})
export class ProverbComponent implements OnInit {
  categories: Category[] = [];
  proverbes: Proverb[] = [];
  selectCategory: number = 0;
  isProvReceived:boolean= false;
  indexProverb: number = 0;
  btnSuivantDisabled:boolean=false;
  constructor(private dataService: DataService) { }

  ngOnInit() {
    this.dataService.getCategories()
      .subscribe((res: Category[]) => {
        this.categories = res;
      });
  }

  submit() {
    let params: string =`?cat=${this.selectCategory}`;

    this.dataService.getProverb(params)
      .subscribe((res: Proverb[]) => {
        this.isProvReceived = true;
        this.proverbes = res;
      })
  }

  suivant() {
    // passage à la question suivante
    if (this.indexProverb < this.proverbes.length -1) {
      this.indexProverb++;
      this.btnSuivantDisabled = false;
    }else{
          this.btnSuivantDisabled = true;
    }
  }
  }
