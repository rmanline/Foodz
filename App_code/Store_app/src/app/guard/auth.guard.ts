/*
  Authors : initappz (Rahul Jograna)
  Website : https://initappz.com/
  App Name : ionic 5 groceryee app
  Created : 10-Sep-2020
  This App Template Source code is licensed as per the
  terms found in the Website https://initappz.com/license
  Copyright and Good Faith Purchasers © 2020-present initappz.
*/
import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { ApiService } from '../services/api.service';


@Injectable({
    providedIn: 'root'
})
export class AuthGuard implements CanActivate {
    constructor(
        private router: Router,
        private api: ApiService
    ) {
    }

    canActivate(): Observable<boolean> | Promise<boolean> | boolean {
        return new Promise(res => {


            this.api.post_private('users/validateStoreToken', {}).subscribe(
                (data: any) => {
                    if (data && data.status === 200 && data.data && data.data.status === 200) {
                        res(true);
                    } else {
                        localStorage.removeItem('uid');
                        localStorage.removeItem('token');
                        this.router.navigate(['/login']);
                        res(false);
                    }
                },
                (error) => {
                    localStorage.removeItem('uid');
                    localStorage.removeItem('token');
                    this.router.navigate(['/login']);
                    res(false);
                }
            );

        });
    }
}
