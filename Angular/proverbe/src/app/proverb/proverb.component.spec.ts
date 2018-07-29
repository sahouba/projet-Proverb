import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ProverbComponent } from './proverb.component';

describe('ProverbComponent', () => {
  let component: ProverbComponent;
  let fixture: ComponentFixture<ProverbComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ProverbComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ProverbComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
