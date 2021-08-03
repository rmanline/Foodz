import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { ApisService } from '../services/apis.service';

@Injectable({
    providedIn: 'root'
})
export class AuthGuard implements CanActivate {

    constructor(private authServ: ApisService, private router: Router) { }

    canActivate(): Observable<boolean> | Promise<boolean> | boolean {
        return new Promise(res => {


            this.authServ.post_private('users/validateAdminToken', {}).then(
                (data) => {
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
